"use client";

import { useState, useEffect, useCallback } from "react";
import SettingsSection from "@/components/SettingsSection";
import InputField from "@/components/InputField";

interface Config {
  facebook: { enabled: boolean; appId: string; appSecret: string; rateLimitPerSecond: number };
  linkedin: { enabled: boolean; sessionCookie: string; concurrency: number; delayBetweenRequests: number };
  twitter: { enabled: boolean; concurrency: number; delayBetweenRequests: number; timeout: number };
  google: { enabled: boolean; serviceAccountKeyFile: string; dailyQuota: number };
  bing: { enabled: boolean; apiKey: string; dailyQuota: number };
  indexNow: { enabled: boolean; key: string; keyLocation: string };
  cdnWarming: { enabled: boolean; concurrency: number; timeout: number };
  server: { apiKey: string; port: number };
}

export default function SettingsPage() {
  const [config, setConfig] = useState<Config | null>(null);
  const [saving, setSaving] = useState(false);
  const [saveMessage, setSaveMessage] = useState<string | null>(null);

  const fetchConfig = useCallback(async () => {
    try {
      const res = await fetch("/api/settings");
      if (res.ok) setConfig(await res.json());
    } catch { /* ignore */ }
  }, []);

  useEffect(() => {
    fetchConfig();
  }, [fetchConfig]);

  const updateConfig = (section: keyof Config, field: string, value: string | number | boolean) => {
    if (!config) return;
    setConfig({
      ...config,
      [section]: { ...config[section], [field]: value },
    });
  };

  const handleSave = async () => {
    if (!config) return;
    setSaving(true);
    setSaveMessage(null);

    try {
      const res = await fetch("/api/settings", {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(config),
      });

      if (res.ok) {
        setSaveMessage("Konfiguration gespeichert!");
        setTimeout(() => setSaveMessage(null), 3000);
      } else {
        const data = await res.json();
        setSaveMessage(`Fehler: ${data.error}`);
      }
    } catch {
      setSaveMessage("Fehler beim Speichern");
    } finally {
      setSaving(false);
    }
  };

  if (!config) {
    return (
      <div className="text-center py-20 text-gray-400">Lade Konfiguration...</div>
    );
  }

  return (
    <div className="space-y-6">
      <div className="flex items-center justify-between">
        <h2 className="text-xl font-bold">Einstellungen</h2>
        <div className="flex items-center gap-3">
          {saveMessage && (
            <span className={`text-sm ${saveMessage.startsWith("Fehler") ? "text-red-400" : "text-green-400"}`}>
              {saveMessage}
            </span>
          )}
          <button
            onClick={handleSave}
            disabled={saving}
            className="bg-orange-600 hover:bg-orange-700 disabled:opacity-50 text-white font-medium py-2 px-4 rounded-md transition-colors"
          >
            {saving ? "Speichert..." : "Speichern"}
          </button>
        </div>
      </div>

      {/* CDN Warming */}
      <SettingsSection
        title="CDN Edge Cache Warming"
        description="Headless Browser (Puppeteer/Chromium) besucht jede URL, um den CDN-Cache aufzuwaermen."
        enabled={config.cdnWarming.enabled}
        onToggle={(v) => updateConfig("cdnWarming", "enabled", v)}
      >
        <div className="grid grid-cols-2 gap-4">
          <InputField
            label="Concurrency"
            value={String(config.cdnWarming.concurrency)}
            onChange={(v) => updateConfig("cdnWarming", "concurrency", parseInt(v) || 3)}
            type="number"
            helpText="Anzahl paralleler Browser-Tabs"
          />
          <InputField
            label="Timeout (ms)"
            value={String(config.cdnWarming.timeout)}
            onChange={(v) => updateConfig("cdnWarming", "timeout", parseInt(v) || 30000)}
            type="number"
            helpText="Maximale Wartezeit pro URL"
          />
        </div>
      </SettingsSection>

      {/* Facebook */}
      <SettingsSection
        title="Facebook Sharing Debugger"
        description="Invalidiert den OG-Tag-Cache ueber die Facebook Graph API."
        enabled={config.facebook.enabled}
        onToggle={(v) => updateConfig("facebook", "enabled", v)}
      >
        <div className="grid grid-cols-2 gap-4">
          <InputField
            label="App ID"
            value={config.facebook.appId}
            onChange={(v) => updateConfig("facebook", "appId", v)}
            placeholder="123456789012345"
            helpText="Facebook App ID von developers.facebook.com"
          />
          <InputField
            label="App Secret"
            value={config.facebook.appSecret}
            onChange={(v) => updateConfig("facebook", "appSecret", v)}
            type="password"
            placeholder="abc123def456..."
            helpText="Facebook App Secret"
          />
          <InputField
            label="Rate Limit (Req/Sek)"
            value={String(config.facebook.rateLimitPerSecond)}
            onChange={(v) => updateConfig("facebook", "rateLimitPerSecond", parseInt(v) || 10)}
            type="number"
            helpText="Max. Anfragen pro Sekunde"
          />
        </div>
      </SettingsSection>

      {/* LinkedIn */}
      <SettingsSection
        title="LinkedIn Post Inspector"
        description="Aktualisiert den LinkedIn-Cache ueber den Post Inspector (Puppeteer + Session Cookie)."
        enabled={config.linkedin.enabled}
        onToggle={(v) => updateConfig("linkedin", "enabled", v)}
      >
        <div className="space-y-4">
          <InputField
            label="Session Cookie (li_at)"
            value={config.linkedin.sessionCookie}
            onChange={(v) => updateConfig("linkedin", "sessionCookie", v)}
            type="password"
            placeholder="AQEDAQe..."
            helpText="li_at Cookie aus den Browser DevTools extrahieren"
          />
          <div className="grid grid-cols-2 gap-4">
            <InputField
              label="Concurrency"
              value={String(config.linkedin.concurrency)}
              onChange={(v) => updateConfig("linkedin", "concurrency", parseInt(v) || 1)}
              type="number"
              helpText="Empfohlen: 1 (Rate-Limit!)"
            />
            <InputField
              label="Verzoegerung (ms)"
              value={String(config.linkedin.delayBetweenRequests)}
              onChange={(v) => updateConfig("linkedin", "delayBetweenRequests", parseInt(v) || 5000)}
              type="number"
              helpText="Wartezeit zwischen Anfragen"
            />
          </div>
        </div>
      </SettingsSection>

      {/* Twitter/X */}
      <SettingsSection
        title="Twitter/X Card Cache"
        description="Triggert das Card-Scraping ueber den Tweet Composer Endpoint."
        enabled={config.twitter.enabled}
        onToggle={(v) => updateConfig("twitter", "enabled", v)}
      >
        <div className="grid grid-cols-3 gap-4">
          <InputField
            label="Concurrency"
            value={String(config.twitter.concurrency)}
            onChange={(v) => updateConfig("twitter", "concurrency", parseInt(v) || 2)}
            type="number"
          />
          <InputField
            label="Verzoegerung (ms)"
            value={String(config.twitter.delayBetweenRequests)}
            onChange={(v) => updateConfig("twitter", "delayBetweenRequests", parseInt(v) || 3000)}
            type="number"
          />
          <InputField
            label="Timeout (ms)"
            value={String(config.twitter.timeout)}
            onChange={(v) => updateConfig("twitter", "timeout", parseInt(v) || 15000)}
            type="number"
          />
        </div>
      </SettingsSection>

      {/* Google Indexing API */}
      <SettingsSection
        title="Google Indexing API"
        description="Benachrichtigt Google ueber URL-Aenderungen via Indexing API."
        enabled={config.google.enabled}
        onToggle={(v) => updateConfig("google", "enabled", v)}
      >
        <div className="grid grid-cols-2 gap-4">
          <InputField
            label="Service Account Key File"
            value={config.google.serviceAccountKeyFile}
            onChange={(v) => updateConfig("google", "serviceAccountKeyFile", v)}
            placeholder="./credentials/google-sa-key.json"
            helpText="Pfad zur JSON-Key-Datei des Google Service Accounts"
          />
          <InputField
            label="Taegliches Limit"
            value={String(config.google.dailyQuota)}
            onChange={(v) => updateConfig("google", "dailyQuota", parseInt(v) || 200)}
            type="number"
            helpText="Max. 200 URLs/Tag pro Property"
          />
        </div>
      </SettingsSection>

      {/* Bing Webmaster */}
      <SettingsSection
        title="Bing Webmaster Tools"
        description="URL-Submission ueber die Bing Webmaster API."
        enabled={config.bing.enabled}
        onToggle={(v) => updateConfig("bing", "enabled", v)}
      >
        <div className="grid grid-cols-2 gap-4">
          <InputField
            label="API Key"
            value={config.bing.apiKey}
            onChange={(v) => updateConfig("bing", "apiKey", v)}
            type="password"
            placeholder="Bing Webmaster API Key"
            helpText="Von bing.com/webmasters"
          />
          <InputField
            label="Taegliches Limit"
            value={String(config.bing.dailyQuota)}
            onChange={(v) => updateConfig("bing", "dailyQuota", parseInt(v) || 10000)}
            type="number"
            helpText="Standard: 10.000 URLs/Tag"
          />
        </div>
      </SettingsSection>

      {/* IndexNow */}
      <SettingsSection
        title="IndexNow"
        description="Offenes Protokoll fuer Bing, Yandex, Seznam und Naver."
        enabled={config.indexNow.enabled}
        onToggle={(v) => updateConfig("indexNow", "enabled", v)}
      >
        <div className="grid grid-cols-2 gap-4">
          <InputField
            label="IndexNow Key"
            value={config.indexNow.key}
            onChange={(v) => updateConfig("indexNow", "key", v)}
            placeholder="a1b2c3d4e5f6..."
            helpText="Selbst generierter alphanumerischer Key"
          />
          <InputField
            label="Key Location (URL)"
            value={config.indexNow.keyLocation}
            onChange={(v) => updateConfig("indexNow", "keyLocation", v)}
            placeholder="https://example.com/key.txt"
            helpText="URL zur gehosteten Key-Datei auf deiner Website"
          />
        </div>
      </SettingsSection>

      {/* Save Button (bottom) */}
      <div className="flex justify-end pt-4">
        <button
          onClick={handleSave}
          disabled={saving}
          className="bg-orange-600 hover:bg-orange-700 disabled:opacity-50 text-white font-medium py-2.5 px-6 rounded-md transition-colors"
        >
          {saving ? "Speichert..." : "Alle Einstellungen speichern"}
        </button>
      </div>
    </div>
  );
}
