"use client";

import { useState, useEffect, useCallback } from "react";

interface Sitemap {
  id: string;
  url: string;
  domain: string;
  cron_expression: string | null;
  created_at: string;
  last_warmed_at: string | null;
}

export default function SitemapManager() {
  const [sitemaps, setSitemaps] = useState<Sitemap[]>([]);
  const [newUrl, setNewUrl] = useState("");
  const [newCron, setNewCron] = useState("");
  const [adding, setAdding] = useState(false);

  const fetchSitemaps = useCallback(async () => {
    try {
      const res = await fetch("/api/sitemaps");
      if (res.ok) {
        const data = await res.json();
        setSitemaps(data.sitemaps);
      }
    } catch { /* ignore */ }
  }, []);

  useEffect(() => {
    fetchSitemaps();
  }, [fetchSitemaps]);

  const handleAdd = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!newUrl) return;
    setAdding(true);

    try {
      const res = await fetch("/api/sitemaps", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          url: newUrl,
          cronExpression: newCron || undefined,
        }),
      });

      if (res.ok) {
        setNewUrl("");
        setNewCron("");
        await fetchSitemaps();
      }
    } finally {
      setAdding(false);
    }
  };

  const handleDelete = async (id: string) => {
    const res = await fetch(`/api/sitemaps/${id}`, { method: "DELETE" });
    if (res.ok) await fetchSitemaps();
  };

  const handleWarm = async (sitemapUrl: string) => {
    await fetch("/api/warm", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        sitemapUrl,
        targets: ["cdn", "facebook", "linkedin", "twitter", "google", "bing", "indexnow"],
      }),
    });
  };

  return (
    <div className="space-y-4">
      {/* Add Form */}
      <form onSubmit={handleAdd} className="bg-gray-900 border border-gray-800 rounded-lg p-4">
        <div className="flex gap-3 items-end">
          <div className="flex-1">
            <label className="block text-sm font-medium text-gray-300 mb-1">Sitemap URL</label>
            <input
              type="url"
              value={newUrl}
              onChange={(e) => setNewUrl(e.target.value)}
              placeholder="https://www.example.com/sitemap.xml"
              required
              className="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500"
            />
          </div>
          <div className="w-48">
            <label className="block text-sm font-medium text-gray-300 mb-1">
              Cron <span className="text-gray-500">(optional)</span>
            </label>
            <input
              type="text"
              value={newCron}
              onChange={(e) => setNewCron(e.target.value)}
              placeholder="0 3 * * *"
              className="w-full bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500"
            />
          </div>
          <button
            type="submit"
            disabled={adding || !newUrl}
            className="bg-orange-600 hover:bg-orange-700 disabled:opacity-50 text-white font-medium py-2 px-4 rounded-md transition-colors whitespace-nowrap"
          >
            {adding ? "..." : "Hinzufuegen"}
          </button>
        </div>
      </form>

      {/* Sitemap List */}
      {sitemaps.length === 0 ? (
        <div className="bg-gray-900 border border-gray-800 rounded-lg p-8 text-center text-gray-500">
          Noch keine Sitemaps registriert.
        </div>
      ) : (
        <div className="bg-gray-900 border border-gray-800 rounded-lg overflow-hidden">
          <table className="w-full">
            <thead>
              <tr className="border-b border-gray-800 text-left text-sm text-gray-400">
                <th className="px-4 py-3">Domain</th>
                <th className="px-4 py-3">URL</th>
                <th className="px-4 py-3">Cron</th>
                <th className="px-4 py-3">Letztes Warming</th>
                <th className="px-4 py-3">Aktionen</th>
              </tr>
            </thead>
            <tbody>
              {sitemaps.map((sm) => (
                <tr key={sm.id} className="border-b border-gray-800/50 hover:bg-gray-800/30">
                  <td className="px-4 py-3 text-sm font-medium">{sm.domain}</td>
                  <td className="px-4 py-3 text-sm font-mono text-gray-400 truncate max-w-xs" title={sm.url}>
                    {sm.url}
                  </td>
                  <td className="px-4 py-3 text-sm text-gray-400">
                    {sm.cron_expression || <span className="text-gray-600">-</span>}
                  </td>
                  <td className="px-4 py-3 text-sm text-gray-400">
                    {sm.last_warmed_at ? new Date(sm.last_warmed_at).toLocaleString("de-DE") : "-"}
                  </td>
                  <td className="px-4 py-3">
                    <div className="flex gap-2">
                      <button
                        onClick={() => handleWarm(sm.url)}
                        className="text-orange-500 hover:text-orange-400 text-sm"
                      >
                        Jetzt aufwaermen
                      </button>
                      <button
                        onClick={() => handleDelete(sm.id)}
                        className="text-red-500 hover:text-red-400 text-sm"
                      >
                        Loeschen
                      </button>
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}
    </div>
  );
}
