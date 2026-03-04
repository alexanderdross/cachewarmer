# SearchForge — Extended Plugin Development Plan

## Context

The original SearchForge plan defines a WordPress plugin that unifies 4 search data sources (GSC, Bing Webmaster, Keyword Planner, Trends) into LLM-ready markdown briefs. The user wants this concept extended with additional high-value functionalities and a refined Pro monetization strategy. This document extends the original plan with new feature modules, a market-informed pricing model, and technical architecture.

**Key market insight:** No WordPress plugin currently occupies the "SEO data → LLM context" category. The closest competitors (Rank Math, Yoast, AIOSEO) focus on on-page optimization, not data synthesis and AI-ready export. Standalone tools (Ahrefs at $348/yr, Semrush at $1,399/yr) are 5-20x more expensive. SearchForge fills a genuine gap at a WordPress-friendly price point.

---

## Quick Reference: Free vs Pro Feature Assignment

### FREE (€0) — "Try SearchForge, see the value"
- Google Search Console: limited to 10 pages, 100 keywords
- SearchForge Score: overall number only (no breakdown)
- Basic `llms.txt` generation
- Dashboard with GSC overview
- 30-day data retention
- Single site

### PRO (€99/yr) — "Full power for a single site"
- **All data sources:** GSC (unlimited), Bing Webmaster, Keyword Planner, Trends, GA4, Google Business Profile (1 location), Bing Places (1 location)
- AI Visibility Monitor (AEO): 20 queries/mo
- Competitor SERP Intelligence: 10 keywords/mo
- Combined Master Brief + LLM Quick Brief export
- SearchForge Score with full breakdown + recommendations
- AI Content Brief generator (10/mo, or unlimited with own API key)
- Keyword cannibalization detection, clustering, content gap analysis
- Historical snapshots (weekly), YoY comparison, decay detection
- Alerts (email), weekly digest
- Advanced `llms.txt` with SEO data
- 12-month data retention
- WP-CLI, Read-only REST API
- Yoast/Rank Math/AIOSEO compatibility

### AGENCY (€249/yr) — "Manage multiple client sites"
- Everything in Pro, plus:
- 10 sites, unlimited team members
- Google Business Profile + Bing Places: up to 10 locations each
- AEO: 200 queries/mo, Competitors: 100 keywords/mo
- Multi-site dashboard, client portal (read-only shareable links)
- White-label PDF/HTML reports, bulk brief generation
- Scheduled exports (email, cloud, GitHub), full REST API (CRUD)
- Slack/Discord alerts, Zapier/Make/n8n webhooks
- GitHub/GitLab push, Notion/Sheets sync
- CacheWarmer integration (auto-trigger)
- 24-month data retention

### ENTERPRISE (€599/yr) — "Unlimited scale"
- Everything in Agency, plus:
- Unlimited sites, unlimited locations
- Custom configuration, priority support
- Audit log

---

## Complete Data Source List (8 Sources)

| # | Source | API | Auth Method | Free | Pro |
|---|--------|-----|-------------|:----:|:---:|
| 1 | Google Search Console | Search Console API v3 | OAuth 2.0 | 10 pages | Unlimited |
| 2 | Bing Webmaster Tools | Bing Webmaster API | OAuth 2.0 / API Key | — | Unlimited |
| 3 | Google Keyword Planner | Google Ads API | OAuth 2.0 (Ads account) | — | Unlimited |
| 4 | Google Trends | SerpApi / Unofficial API | API Key | — | Unlimited |
| 5 | Google Analytics 4/5 | GA Data API v1 | OAuth 2.0 | — | Unlimited |
| 6 | Google Business Profile | Business Profile API | OAuth 2.0 | — | 1 location |
| 7 | Bing Places for Business | Bing Places API | OAuth 2.0 | — | 1 location |
| 8 | SerpApi (for AEO + Competitors) | SerpApi | API Key (user-provided) | — | Metered |

> **Note on GA5:** Google has not yet announced GA5 as of March 2026. The plugin targets GA4 (Google Analytics 4) via the GA Data API v1. If Google releases a GA5, the modular architecture allows adding a new data connector without affecting existing functionality.

---

## Core Data Sources (Modules 1-4, from Original Plan)

The original plan covers these 4 core data sources, which remain fully in scope:

### Module 1: Google Search Console (GSC)
- OAuth 2.0 authentication via Google API
- Pull: clicks, impressions, CTR, average position per page and per query
- Device segmentation (desktop, mobile, tablet)
- Date range selection (7d, 28d, 3mo, 6mo, 12mo, custom)
- Per-page and per-query markdown export
- **Free:** 10 pages | **Pro+:** Unlimited

### Module 2: Bing Webmaster Tools
- OAuth 2.0 or API Key authentication
- Pull: clicks, impressions, CTR, position per page and per query
- Bing-specific keyword data (often different from Google)
- Merged view with GSC data (side-by-side comparison)
- Per-page markdown export with Bing-specific metrics
- **Pro+:** Full access

### Module 3: Google Keyword Planner (via Google Ads API)
- OAuth 2.0 via Google Ads account (requires active Ads account, even with $0 spend)
- Pull: monthly search volume, competition level, CPC data, seasonal trends
- Enrich GSC/Bing keywords with volume data (GSC shows impressions, not absolute volume)
- Keyword suggestions for content gaps
- Volume-enriched markdown export
- **Pro+:** Full access

### Module 4: Google Trends
- Via SerpApi or unofficial Google Trends API (pytrends-style)
- Pull: relative interest over time, related queries, rising queries
- Geographic breakdown (country, region, city)
- Seasonal pattern detection for content calendar
- Trend-enriched markdown export
- **Pro+:** Full access

---

## Extended Feature Modules (New Sources & Intelligence)

### Module 5: AI Search Visibility Monitor (AEO — Answer Engine Optimization)

**Why:** 40%+ of queries now answered by AI without click-through. No WP plugin monitors this.

| Feature | Description |
|---------|-------------|
| AI Citation Tracking | Monitor if/how your pages are cited in ChatGPT, Perplexity, Google AI Overviews, Bing Copilot |
| Citation Markdown Export | Export citation data per page: which AI engines cite you, for which queries, link back frequency |
| AI Visibility Score | Proprietary 0-100 score: how likely your page is to be cited by AI engines |
| `llms.txt` Auto-Generation | Generate and maintain `/llms.txt` and `/llms-full.txt` for AI crawler discoverability |
| Structured Data Audit | Check if pages have proper schema markup that AI engines prefer |

**Implementation:** Periodic SerpApi/Brave API queries for your target keywords → check if AI overview/featured snippet cites your domain → store results → trend over time.

**Markdown output (`aeo-[slug].md`):**
```markdown
# AI Visibility Report: /germany/
**Source:** SearchForge AEO Monitor
**Period:** 2025-12-03 → 2026-03-02

## AI Engine Citations
| Engine           | Cited | Queries Checked | Citation Rate | Trend  |
|------------------|-------|-----------------|---------------|--------|
| Google AI Overview| Yes  | 12              | 58%           | Stable |
| ChatGPT          | Yes   | 8               | 25%           | ↑ +15% |
| Perplexity       | No    | 8               | 0%            | —      |
| Bing Copilot     | Yes   | 6               | 33%           | ↑ New  |

## Queries Where You ARE Cited by AI
| Query              | Engine           | Position | Link Back |
|--------------------|------------------|----------|-----------|
| aip germany        | Google AI, ChatGPT| Source 1 | Yes       |
| germany aip pdf    | Google AI        | Source 3 | No (summary only) |

## Queries Where You SHOULD Be Cited (High Rank, No AI Citation)
| Query                | GSC Position | AI Engines Checked | Gap Action |
|----------------------|-------------|-------------------|------------|
| german aviation charts| 4.2        | Google AI, ChatGPT | Add FAQ schema, expand answer format |
```

---

### Module 6: Competitor SERP Intelligence

**Why:** Understanding who ranks above/below you on shared keywords, without paying $1,400/yr for Semrush.

| Feature | Description |
|---------|-------------|
| SERP Snapshot | For your top keywords, capture who ranks in positions 1-10 (via SerpApi) |
| Competitor Domain Detection | Auto-identify recurring competitor domains across your keyword set |
| Content Gap vs Competitors | Keywords where competitors rank but you don't |
| SERP Feature Tracking | Track which SERP features appear (featured snippets, PAA, video, images) and who owns them |
| Competitor Markdown Export | Export competitor analysis per page for LLM context |

**Markdown output (`competitors-[slug].md`):**
```markdown
# Competitor Intelligence: /germany/
**Source:** SearchForge SERP Monitor
**Top 3 Competitors on Shared Keywords:**

## Competitor Overview
| Domain              | Shared Keywords | Avg Position | Your Avg Position | Delta |
|---------------------|----------------|-------------|-------------------|-------|
| skyvector.com       | 8              | 3.2         | 4.1               | -0.9  |
| eurocontrol.int     | 6              | 2.8         | 5.4               | -2.6  |
| dfs.de              | 5              | 1.9         | 6.2               | -4.3  |

## SERP Feature Ownership
| Keyword          | Featured Snippet | PAA | Image Pack | Your Feature |
|------------------|-----------------|-----|------------|-------------|
| aip germany      | eurocontrol.int | Yes | You (pos 2)| Image Pack  |
| germany aip pdf  | None            | Yes | None       | None — opportunity |

## Content Gaps (Competitors Rank, You Don't)
| Keyword                | Competitor       | Their Position | Monthly Volume |
|------------------------|-----------------|---------------|---------------|
| ICAO chart germany     | skyvector.com   | 2.1           | 390           |
| german airspace map    | dfs.de          | 1.4           | 520           |
```

---

### Module 7: Google Analytics 4 Integration (On-Page Behavior)

**Why:** GSC tells you what drives clicks; GA4 tells you what happens after the click.

| Feature | Description |
|---------|-------------|
| Bounce Rate per Page | Identify pages that rank well but don't satisfy intent |
| Engagement Time | Average time on page, correlated with search position |
| Scroll Depth | Where users drop off — signals content length issues |
| Conversion Attribution | Which search queries drive actual conversions |
| Behavior + Search Correlation | Combined brief: "720 searches/mo, rank #4, but 78% bounce = content mismatch" |

**Markdown output (merged into master brief):**
```markdown
## On-Page Behavior (GA4)
| Metric              | Value    | Benchmark | Signal           |
|---------------------|----------|-----------|------------------|
| Bounce Rate         | 68%      | 45%       | Content mismatch |
| Avg Engagement Time | 1:12     | 2:30      | Below average    |
| Scroll to 50%       | 42%      | 60%       | Users abandon early |
| Conversions (goal)  | 3        | 8         | Low conversion   |

**LLM Note:** Users search "aip germany pdf" and click (CTR 14.3%), but 68%
bounce immediately. The page doesn't deliver a visible PDF download above the fold.
This is a UX problem, not an SEO problem — the content satisfies the query intent
but the page layout fails to deliver.
```

---

### Module 7b: Google Business Profile + Bing Places (Local SEO Intelligence)

**Why:** Businesses with physical locations need local search data. Google Business Profile (formerly Google My Business) and Bing Places provide keywords and metrics not available in GSC/Bing Webmaster — specifically the queries that trigger your business listing in Maps and local search results.

#### Google Business Profile (GBP)

| Feature | Description |
|---------|-------------|
| GBP Search Queries | Pull keywords that triggered your business listing (different from website SEO keywords!) |
| Direct vs Discovery Queries | "Direct" = searched your name; "Discovery" = found you via category/product keywords |
| Maps vs Search Split | How many views came from Google Maps vs. Google Search |
| Customer Actions | Track calls, direction requests, website clicks from your listing |
| Photo Views & Engagement | Photo view count vs. competitors in your category |
| Review Sentiment Keywords | Extract recurring keywords from customer reviews (e.g., "great pizza", "slow service") |
| Local Keyword Gap | Keywords where competitors' listings appear but yours doesn't |
| Local SEO Markdown Export | Export all local metrics for LLM context |

#### Bing Places for Business

| Feature | Description |
|---------|-------------|
| Bing Places Impressions | How often your listing appeared in Bing local results and Bing Maps |
| Bing Places Actions | Clicks, calls, direction requests from Bing Maps |
| Bing Local Keywords | Discovery keywords specific to Bing's search audience (often different demographics than Google) |
| Cross-Platform Local Comparison | Side-by-side Google vs Bing local performance — identify where Bing delivers traffic that Google doesn't |

**Implementation:**
- Google Business Profile API (OAuth 2.0, same Google Cloud project as GSC). Requires verified GBP listing.
- Bing Places for Business API (uses same Bing Webmaster OAuth credentials). Requires verified Bing Places listing.

**Markdown output (`local-seo-[business-name].md`):**
```markdown
# Local SEO Report: Dross Media GmbH
**Source:** Google Business Profile + Bing Places
**Period:** 2026-02-01 → 2026-03-01

## Discovery vs Direct Searches (Google)
| Type       | Searches | % of Total | Trend (MoM) |
|------------|----------|------------|-------------|
| Discovery  | 1,240    | 72%        | ↑ +8%       |
| Direct     | 480      | 28%        | Stable      |

## Top Discovery Keywords (Google vs Bing)
| Keyword                    | Google Impr. | Bing Impr. | Google Actions | Bing Actions |
|----------------------------|-------------|------------|----------------|--------------|
| web agentur stuttgart      | 320         | 45         | 28             | 6            |
| seo beratung stuttgart     | 180         | 22         | 15             | 3            |
| wordpress entwickler       | 145         | 18         | 8              | 2            |
| cache warming service      | 89          | 31         | 12             | 5            |

## Customer Actions (Cross-Platform)
| Action           | Google | Bing  | Total | MoM Change |
|------------------|--------|-------|-------|------------|
| Website Clicks   | 156    | 28    | 184   | ↑ +12%     |
| Direction Requests| 42    | 8     | 50    | Stable     |
| Phone Calls      | 28     | 4     | 32    | ↓ -5%      |

## Review Keywords (Sentiment Analysis — Google)
| Keyword           | Frequency | Sentiment | Stars Avg |
|-------------------|-----------|-----------|-----------|
| professionell     | 12        | Positive  | 4.8       |
| schnell           | 8         | Positive  | 4.9       |
| preis-leistung    | 5         | Mixed     | 3.8       |

## Bing-Only Discovery Keywords
Keywords where users find you on Bing but NOT on Google:
| Keyword                    | Bing Impressions | Actions |
|----------------------------|-----------------|---------|
| wordpress agentur bw       | 15              | 3       |
| website cache optimierung  | 12              | 2       |

## LLM Note
Your business is primarily found through discovery queries (72% on Google,
68% on Bing). Bing delivers an additional 16% local traffic that Google
doesn't surface. Focus on optimizing your GBP description and services list
for "web agentur stuttgart" and "seo beratung stuttgart". Consider also
claiming and optimizing your Bing Places listing — "website cache optimierung"
is a Bing-only discovery keyword with good action rate.
```

**Konfiguration:**
```yaml
googleBusinessProfile:
  enabled: true
  accountId: "accounts/123456789"
  locationId: "locations/987654321"
  # Uses same OAuth token as GSC (Google Cloud project)

bingPlaces:
  enabled: true
  businessId: "YOUR_BING_PLACES_BUSINESS_ID"
  # Uses same OAuth token as Bing Webmaster Tools
```

**Tier access:**
- **Free:** Not available
- **Pro:** 1 Google Business Profile location + 1 Bing Places location
- **Agency:** Up to 10 locations (each platform)
- **Enterprise:** Unlimited locations

---

### Module 8: Historical Trend Engine

**Why:** Accumulated data over time becomes increasingly valuable and creates lock-in.

| Feature | Description |
|---------|-------------|
| 12-Month Rolling Snapshots | Store weekly GSC/Bing snapshots, compare any two periods |
| Year-over-Year Comparison | "Your /germany/ page had 321 clicks in Q1 2026 vs 198 in Q1 2025" |
| Ranking Trajectory Charts | Per-keyword position tracking over time |
| Content Decay Detection | Alert when a page's rankings start declining (7d trend, 30d trend) |
| Velocity Metrics | Rate of change: "This keyword gained 2.3 positions in 14 days" |
| Historical Markdown Export | Include trend context in briefs: "This page has gained +45% clicks YoY" |

---

### Module 9: Automated Content Briefs & Recommendations

**Why:** Raw data requires interpretation. AI-generated briefs save hours per page.

| Feature | Description |
|---------|-------------|
| AI-Generated Page Brief | One-click brief per page: what to change, why, expected impact |
| Content Gap Prioritizer | Ranked list of content opportunities with estimated traffic potential |
| Meta Tag Generator | AI-generated title/description variants optimized for top queries |
| Internal Linking Suggestions | Based on keyword overlap between pages, suggest internal links |
| Content Calendar | Auto-generated publishing calendar based on seasonal trends |
| Schema Markup Recommendations | Suggest schema types based on query intent analysis |
| Keyword Cannibalization Detection | Identify pages competing for the same keywords (multiple URLs ranking for same query in GSC), flag with severity scores |
| Keyword Clustering | Group GSC keywords by semantic similarity (TF-IDF / n-gram Jaccard) into topic clusters, each linked to a pillar page suggestion |

**Implementation:** Uses OpenAI/Claude API (user provides their own key) or ships with a lightweight heuristic engine for Pro users without API keys. Clustering runs locally in PHP (no external AI API needed for basic grouping).

---

### Module 9b: SearchForge Score (Proprietary Scoring System)

**Why:** A proprietary score creates a memorable metric that competitors don't have. It drives engagement ("check your score") and conversion ("unlock the breakdown").

**SearchForge Score: 0-100, composed of 4 sub-scores:**

| Component | Weight | Inputs |
|-----------|--------|--------|
| **Technical SEO** | 25% | Schema markup presence, mobile-friendliness (GSC device data), Core Web Vitals hints, heading structure |
| **Content Quality** | 25% | Keyword coverage depth, heading structure analysis, content length vs. competitors, internal linking density |
| **Authority** | 25% | GSC link data, internal link count, referring domains (if available), brand query volume |
| **Momentum** | 25% | Ranking trends (7d/30d/90d), impression growth rate, new keyword acquisitions, CTR vs. expected CTR for position |

**Free tier:** Shows overall score only (e.g., "64/100")
**Pro tier:** Full breakdown with per-component recommendations

**Opportunity Score (per keyword):**
Calculated from: current position proximity to page 1 + search volume + competition level + trend direction + CTR gap (actual vs. expected for position). Outputs a priority ranking for where to focus effort.

---

### Module 9c: Yoast / Rank Math / AIOSEO Compatibility Layer

**Why:** Most SearchForge users will already run an SEO plugin. Integration prevents duplication and adds value.

| Integration | What It Does |
|-------------|-------------|
| Import Focus Keywords | Cross-reference their configured focus keywords with actual GSC performance data |
| Pull Readability Scores | Enrich content briefs with existing readability analysis |
| Use Their Sitemap | Read sitemap configuration from the existing plugin instead of duplicating |
| SEO Score Comparison | Show SearchForge Score alongside Yoast/Rank Math score for the same page |

---

### Module 10: Alerting & Monitoring System

**Why:** Recurring value that justifies ongoing subscription.

| Feature | Description |
|---------|-------------|
| Ranking Drop Alerts | Email/webhook when a top keyword drops >3 positions |
| Traffic Anomaly Detection | Alert on unusual traffic spikes or drops (statistical outlier detection) |
| New Keyword Detection | "Your page started ranking for 5 new keywords this week" |
| Competitor Movement Alerts | "skyvector.com overtook you for 'aip germany'" |
| Content Decay Warnings | "3 pages have lost >20% clicks in the last 30 days" |
| Quota Usage Alerts | API quota approaching limits (GSC, Keyword Planner) |
| Weekly Digest Email | Automated summary of key changes, top opportunities, alerts |

---

### Module 11: Collaboration & Agency Features

**Why:** Agencies managing 5-50 client sites need workflow tools.

| Feature | Description |
|---------|-------------|
| Multi-Site Dashboard | Single pane of glass across all client sites |
| Client-Branded Reports | White-label PDF/HTML reports with agency branding |
| Team Roles | Admin, Editor, Viewer permissions per site |
| Scheduled Exports | Auto-export briefs weekly/monthly to email or cloud storage |
| Client Portal | Read-only dashboard link for clients (shareable URL with token) |
| Bulk Brief Generation | Generate briefs for all pages across all sites in one click |

---

### Module 12: Integration Ecosystem

| Integration | Direction | Description |
|-------------|-----------|-------------|
| WooCommerce | Internal | Product page SEO scoring, category cannibalization detection, product schema validation |
| CacheWarmer | Outbound | After generating briefs, trigger cache warming for updated pages |
| Slack/Discord | Outbound | Alert notifications to team channels |
| Zapier/Make/n8n | Outbound | Webhook events for all alerts and exports |
| Google Sheets | Export | Push performance data to Sheets for custom dashboards |
| Notion/Obsidian | Export | Direct export to Notion databases or Obsidian vault |
| GitHub/GitLab | Export | Push markdown briefs directly to a repository (perfect for Claude Code) |
| REST API | Bidirectional | Full programmatic access to all SearchForge data |
| WP-CLI | Local | Terminal-based export and sync commands |

---

## Revised Tier Structure & Pricing

### Market-Informed Pricing Rationale

- WordPress SEO plugin sweet spot: $49-$199/yr
- SearchForge replaces partial functionality of $348-$1,400/yr standalone tools
- CacheWarmer uses $99/$599+ pricing — SearchForge should complement, not cannibalize
- Free tier must be genuinely useful (drives wordpress.org discovery, 1-2% conversion)

### Tier Matrix

#### Data Sources

| Feature | Free | Pro | Agency |
|---------|:----:|:---:|:------:|
| Google Search Console | 10 pages | Unlimited | Unlimited |
| Bing Webmaster Tools | — | Unlimited | Unlimited |
| Google Keyword Planner | — | Unlimited | Unlimited |
| Google Trends | — | Unlimited | Unlimited |
| Google Analytics 4 | — | Unlimited | Unlimited |
| Google Business Profile (Local SEO) | — | 1 location | 10 locations (Enterprise: unlimited) |
| Bing Places for Business (Local SEO) | — | 1 location | 10 locations (Enterprise: unlimited) |
| AI Visibility Monitor (AEO) | — | 20 queries/mo | 200 queries/mo |
| Competitor SERP Intelligence | — | 10 keywords/mo | 100 keywords/mo |

#### Export & Output

| Feature | Free | Pro | Agency |
|---------|:----:|:---:|:------:|
| Per-Source Markdown Export | GSC only | All sources | All sources |
| Combined Master Brief | — | Per page | Per page |
| LLM Quick Brief (token-optimized) | — | Per page | Per page |
| Full Site Overview Brief | — | — | Single .md for entire domain |
| `llms.txt` Auto-Generation | Basic | Advanced (with SEO data) | Advanced |
| ZIP Export (bulk) | — | All pages | All pages, all sites |
| Scheduled Exports (weekly/monthly) | — | — | Email, cloud, GitHub |
| PDF/HTML Reports | — | — | White-label branded |
| WP-CLI | — | Single site | Multi-site |

#### Analysis & Intelligence

| Feature | Free | Pro | Agency |
|---------|:----:|:---:|:------:|
| Content Gap Analysis | Top 3 | Unlimited | Unlimited |
| Meta Tag Recommendations | — | AI-generated | AI-generated |
| Internal Linking Suggestions | — | Per page | Cross-site |
| Schema Markup Recommendations | — | Per page | Per page |
| Content Calendar (seasonal) | — | Annual | Annual |
| AI Content Brief Generator | — | 10/mo (own API key: unlimited) | 50/mo (own API key: unlimited) |
| Opportunity Score (proprietary) | — | Per page | Per page |

#### Historical & Monitoring

| Feature | Free | Pro | Agency |
|---------|:----:|:---:|:------:|
| Data Retention | 30 days | 12 months | 24 months |
| Historical Snapshots | — | Weekly | Daily |
| YoY Comparison | — | Per page | Per page |
| Ranking Trajectory Charts | — | Per keyword | Per keyword |
| Content Decay Detection | — | Alerts | Alerts + auto-brief |
| Ranking Drop Alerts | — | Email | Email + Slack + Webhook |
| Traffic Anomaly Detection | — | — | Statistical |
| Weekly Digest Email | — | Single site | All sites |

#### Collaboration & Scale

| Feature | Free | Pro | Agency |
|---------|:----:|:---:|:------:|
| Sites | 1 | 1 | 10 (Enterprise: unlimited) |
| Team Members | 1 | 3 | Unlimited |
| Client Portal (read-only links) | — | — | Per client |
| Bulk Brief Generation | — | — | Cross-site |
| REST API Access | — | Read-only | Full CRUD |
| Webhook Notifications | — | — | All events |
| CacheWarmer Integration | — | Manual trigger | Auto-trigger |

#### Integrations

| Feature | Free | Pro | Agency |
|---------|:----:|:---:|:------:|
| Notion Export | — | Manual | Scheduled |
| GitHub/GitLab Push | — | — | Auto-push on sync |
| Google Sheets Sync | — | — | Auto-sync |
| Slack/Discord Alerts | — | — | All alert types |
| Zapier/Make/n8n Webhooks | — | — | All events |

### Pricing

| Tier | Annual Price | Monthly Equiv. | Sites |
|------|-------------|---------------|-------|
| **Free** | €0 | €0 | 1 |
| **Pro** | €99/yr | ~€8.25/mo | 1 |
| **Agency** | €249/yr | ~€20.75/mo | 10 |
| **Enterprise** | €599/yr | ~€49.92/mo | Unlimited |
| **Lifetime Pro** | €249 (one-time) | — | 1 |
| **Lifetime Agency** | €599 (one-time) | — | 10 |

**Development License:** Free, Enterprise features, restricted to localhost/\*.local/\*.dev/\*.test.

### Conversion Strategy (Free → Pro)

1. **Show, don't block:** Free users see GSC data for 10 pages. The dashboard shows "Bing data available" / "Keyword volume available" with blurred previews — they can see the value they're missing
2. **Trial mechanism:** 14-day Pro trial on first install (no credit card required)
3. **Export hook:** Free users can view briefs in-dashboard but cannot export. The "Export .md" button shows a Pro upgrade prompt
4. **Content decay nudge:** After 30 days, show "3 pages are declining — upgrade to Pro for alerts and auto-briefs"
5. **Combined brief tease:** Show the combined Master Brief for one page (best-performing), locked for all others
6. **The "100 keyword wall":** Free shows top 100 keywords. When a user has more, they see: "You have 847 keywords. Upgrade to Pro to see all of them and unlock clustering."
7. **Score curiosity gap:** SearchForge Score shown as a single number (e.g., "64/100"). Pro unlocks the breakdown showing *why* and *how to improve*
8. **History cliff:** After 30 days, historical data grays out with "Upgrade to Pro for 12 months of history"
9. **Opportunity teasers:** Show top 3 opportunities, blur the rest: "23 more opportunities detected. Unlock with Pro."

---

## Cross-Product Synergy: SearchForge + CacheWarmer

| Workflow | How It Works |
|----------|-------------|
| Brief → Build → Warm | SearchForge generates brief → developer rebuilds page → CacheWarmer warms caches |
| Decay → Refresh → Warm | SearchForge detects content decay → triggers content refresh → CacheWarmer re-warms |
| Bundle Pricing | "drossmedia SEO Suite" bundle: SearchForge Pro + CacheWarmer Premium at €169/yr (vs €198 separate, 15% discount). Enterprise bundle: €999/yr (vs €1,198 separate, 17% discount) |
| Shared License Dashboard | Both products managed from `forge.drossmedia.de` (or unified `dashboard.drossmedia.de`) |
| Shared WordPress Infrastructure | Same license key format (`SF-{TIER}-{HEX16}`), same CWLM plugin architecture, same Stripe integration |

---

## Technical Architecture

### WordPress Infrastructure

| Component | Technology | Notes |
|-----------|-----------|-------|
| Data Storage | Custom MySQL tables (prefix `wp_sf_`) | 8-10 tables for snapshots, keywords, competitors, alerts |
| Background Sync | Action Scheduler (WooCommerce's library) | More reliable than WP-Cron for long-running API syncs |
| OAuth Token Storage | `wp_options` (encrypted with `SECURE_AUTH_KEY`) | GSC, Bing, GA4, Google Ads tokens |
| Admin Dashboard | React SPA in WP admin (wp-scripts) | Reuse CacheWarmer's admin UI pattern |
| REST API | WP REST API namespace `searchforge/v1` | For external access and WP-CLI backend |
| Export Engine | Server-side Markdown generation | Template-based, per-source and combined |
| Alert System | Action Scheduler + wp_mail + webhook dispatch | Cron-based threshold checks |

### Database Schema (Key Tables)

```
wp_sf_snapshots        — Weekly/daily GSC+Bing data snapshots per page
wp_sf_keywords         — Keyword-level metrics (position, clicks, volume, trend)
wp_sf_competitors      — SERP competitor tracking per keyword
wp_sf_gbp_metrics      — Google Business Profile local SEO data per location
wp_sf_bing_places      — Bing Places for Business local SEO data per location
wp_sf_aeo_citations    — AI engine citation tracking
wp_sf_alerts           — Alert definitions and history
wp_sf_briefs_cache     — Generated markdown briefs (cached)
wp_sf_exports          — Export history and scheduled exports
wp_sf_settings         — OAuth tokens, API keys, preferences
```

### API Rate Limit Strategy

| Source | Limit | Strategy |
|--------|-------|----------|
| GSC API | 25,000 req/day | Batch queries by page, sync in background over hours |
| Bing API | 10,000 req/day | Similar batching, lower priority queue |
| Keyword Planner | 10,000 req/day (with active Ads account) | Cache aggressively, refresh monthly |
| Google Trends | Via SerpApi: 100 searches/mo ($50 plan) | Cache 30 days, refresh on-demand |
| SerpApi (competitors) | 100-5,000/mo depending on plan | User provides own API key; SearchForge manages quota |
| GA4 API | 10,000 req/day | Batch by property, sync daily |
| GBP API (Business Profile) | 60 req/min per project | Batch by location, sync weekly |
| Bing Places API | 10,000 req/day (shared with Bing Webmaster) | Batch by location, sync weekly |

### Data Freshness Model

| Source | Sync Frequency | Latency |
|--------|---------------|---------|
| GSC | Daily (background) | GSC data is 2-4 days behind |
| Bing | Daily (background) | Bing data is 1-3 days behind |
| Keyword Planner | Monthly | Volume data is monthly average |
| Trends | Weekly | Relative interest, weekly granularity |
| GA4 | Daily | 24-48 hour processing delay |
| GBP | Weekly | GBP data is 3-5 days behind |
| Bing Places | Weekly | Bing Places data is 2-4 days behind |
| AEO Monitor | Weekly | SerpApi-dependent |
| Competitors | Weekly | SerpApi-dependent |

---

## Updated Development Phases

| Phase | Scope | Effort | Tier Impact |
|-------|-------|--------|-------------|
| v1.0 | GSC integration, markdown export, dashboard, `llms.txt` | ~80h | Free + Pro |
| v1.1 | Bing Webmaster Tools + combined brief | ~28h | Pro |
| v1.2 | Keyword Planner + content gap analysis | ~32h | Pro |
| v1.3 | Google Trends + seasonal calendar | ~24h | Pro |
| v1.4 | Historical trend engine + content decay detection | ~28h | Pro |
| v1.5 | Alert system (email + webhooks) + weekly digest | ~20h | Pro + Agency |
| v1.6 | GA4 integration + behavior correlation | ~28h | Pro |
| v1.6b | Google Business Profile + Bing Places integration (local SEO keywords) | ~32h | Pro |
| v1.7 | AI Content Brief generator (OpenAI/Claude API) | ~24h | Pro |
| v1.8 | AEO Monitor (AI citation tracking) | ~32h | Pro |
| v1.9 | Competitor SERP intelligence | ~28h | Pro + Agency |
| v2.0 | Agency features: multi-site, white-label, client portal | ~40h | Agency |
| v2.1 | Integration ecosystem: GitHub, Notion, Sheets, Slack | ~32h | Agency |
| v2.2 | WP-CLI + REST API + scheduled exports | ~24h | Pro + Agency |
| v2.3 | CacheWarmer integration + bundle licensing | ~16h | Cross-product |
| **Total** | | **~468h** | |

---

## License Infrastructure (Reusing CacheWarmer's CWLM)

Adapt the existing `cachewarmer-license-manager` WordPress plugin:

- License key prefix: `SF-` instead of `CW-`
- Same CWLM database schema (7 tables)
- Same Stripe webhook flow
- Same feature-gating middleware pattern
- Dashboard URL: `forge.drossmedia.de`
- Shared admin UI components with CacheWarmer dashboard

Feature flags for SearchForge (~30 flags):
```
gsc_enabled, gsc_max_pages, bing_enabled, kwp_enabled, trends_enabled,
ga4_enabled, gbp_enabled, gbp_max_locations, bing_places_enabled, bing_places_max_locations,
aeo_enabled, aeo_max_queries, competitors_enabled,
competitors_max_keywords, export_markdown, export_combined_brief,
export_llm_quick, export_zip, export_scheduled, export_pdf,
llms_txt, llms_txt_advanced, data_retention_days, snapshots_frequency,
yoy_comparison, decay_detection, alerts_email, alerts_slack,
alerts_webhook, weekly_digest, ai_briefs, ai_briefs_max,
max_sites, team_members, client_portal, rest_api, rest_api_write,
wp_cli, github_push, notion_export, cachewarmer_integration
```

---

## Verification

After implementation of each phase:
1. Activate plugin on test WordPress site
2. Connect at least GSC OAuth and verify data sync
3. Export markdown brief for a test page → verify format matches spec
4. Verify `llms.txt` generation at `{site}/llms.txt`
5. Test free-tier limits (10 pages, 30-day retention)
6. Test Pro upgrade flow via Stripe test mode
7. Import exported markdown into Claude Code → verify LLM can parse and act on it
8. Run `wp searchforge export --format=master-brief` via WP-CLI (v2.2+)
