# 🎮 GameTracker

![WordPress](https://img.shields.io/badge/WordPress-custom%20theme-21759B?logo=wordpress&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-custom%20theme%20logic-777BB4?logo=php&logoColor=white)
![RAWG API](https://img.shields.io/badge/RAWG-API%20integration-red)
![Status](https://img.shields.io/badge/status-portfolio%20MVP-blue)

GameTracker is a custom WordPress theme built as a portfolio-stage game discovery and backlog management application. It combines locally managed WordPress game entries with an external RAWG-powered game catalog, custom post metadata, dedicated templates, API response caching, fallback handling, and a responsive dark gaming interface.

The project was built without page builders or heavy plugin dependencies. Its purpose is to demonstrate practical WordPress development in an application-like context: custom PHP, WordPress hooks, custom post types, meta boxes, template architecture, external REST API integration, caching, sanitization, escaping, and clear separation between CMS-managed content and third-party API data.

---

## 📸 Screenshots

### Homepage

![GameTracker homepage](assets/screenshots/home_page.png)

### All Games page

![GameTracker all games page](assets/screenshots/all_games_page.png)

---

## Overview

GameTracker currently has two main content areas:

1. **Local WordPress game entries**  
   Games created and managed inside the WordPress admin panel through a custom `game` post type.

2. **External game discovery catalog**  
   Games fetched from the RAWG Video Games Database API and displayed on a dedicated `All Games` page.

This makes the project more than a static WordPress theme. It includes real data handling, API communication, caching, error fallback logic, custom admin fields, dynamic templates, and frontend presentation built around a clear product idea.

---

## Core Features

- Custom WordPress theme structure
- Custom post type: `game`
- Featured image support for local game posts
- Custom game metadata:
  - Main Story hours
  - Completionist hours
- Admin meta box for editing game completion times
- Homepage with hero section, search UI, and selected local game cards
- Single game template for local WordPress `game` posts
- Dedicated `All Games` page template
- RAWG API integration for external game discovery
- Paginated external game catalog
- RAWG game cards with:
  - title
  - background image
  - release date
  - rating
  - genres
  - external RAWG details link
- Placeholder image fallback for games without a background image
- WordPress Transients API caching
- Separate cache keys for different API query arguments
- Fallback to the last successful RAWG response when the API request fails
- Responsive dark UI styled with custom CSS
- WordPress-safe output escaping for dynamic frontend values

---

## Technical Highlights

| Area | Implementation |
| --- | --- |
| Theme setup | `title-tag`, post thumbnails, custom CSS and JS enqueueing |
| Content model | Custom `game` post type registered through WordPress hooks |
| Admin UI | Custom meta box for game completion time fields |
| Data persistence | Main Story and Completionist values saved as post meta |
| Security checks | Nonce verification, autosave guard, revision guard, capability check |
| External API | RAWG catalog fetched with WordPress HTTP functions |
| Performance | API responses cached with unique transient keys |
| Resilience | Last successful API response reused as fallback data |
| Templates | Separate homepage, catalog page, and single game templates |
| Frontend | Responsive card grid, dark UI, buttons, sticky header, and reusable layout containers |

---

## How It Works

1. WordPress loads the custom theme and enqueues `assets/css/main.css` and `assets/js/main.js`.
2. The theme registers a custom `game` post type for locally managed game entries.
3. Game posts can store additional completion-time metadata through an admin meta box.
4. The homepage displays selected local `game` posts using a custom `WP_Query` loop.
5. The `All Games` page calls the RAWG API through the `gametracker_get_rawg_games()` helper function.
6. RAWG responses are cached with WordPress transients to reduce repeated external requests.
7. If the API request fails, the theme attempts to use the last successful RAWG response before returning an empty catalog.
8. Dynamic values are escaped before being rendered in templates.

---

## RAWG API Integration

The main API logic is handled in `functions.php`:

```php
gametracker_get_rawg_games($page = 1, $page_size = 12, $search = '', $ordering = '', $genre = '')
```

The function handles:

- pagination argument normalization
- API key loading from the `RAWG_API_KEY` constant
- optional search, ordering, and genre parameters at helper-function level
- query argument preparation with `add_query_arg()`
- request execution with `wp_remote_get()`
- HTTP error and status-code checks
- JSON decoding and response validation
- transient cache lookup before making a new API request
- successful response caching
- fallback to the last successful API response when possible

Current template usage:

```php
$games_data = gametracker_get_rawg_games($paged, 12);
```

This means the current `All Games` page uses the paginated catalog view. Search, ordering, and genre filtering are already supported by the helper function, but they are not yet connected to a frontend filter/search form.

---

## Caching Strategy

GameTracker uses the WordPress Transients API to cache external RAWG responses.

| Data | Cache duration |
| --- | --- |
| First catalog page | 1 hour |
| Deeper paginated pages | 10 minutes |
| Last successful API response | 1 day |

Cache keys are generated from the active API query arguments:

```php
$transient_key = 'gametracker_rawg_games_' . md5(json_encode($transient_args));
```

This prevents different catalog requests from overwriting each other and reduces unnecessary API calls.

The fallback transient:

```php
gametracker_rawg_last_success
```

keeps the catalog usable when the external API temporarily fails, returns a non-200 status code, or returns an unexpected response body.

---

## WordPress Implementation

### Custom Post Type

The project registers a custom post type:

```php
register_post_type('game', ...)
```

The `game` post type supports:

- title
- editor
- featured image

### Custom Meta Box

The project adds a `Game Times` meta box for local game posts.

Stored fields:

- `_main_story_hours`
- `_completionist_hours`

These values are displayed on the homepage game cards and on the single game page.

### Templates

The theme includes separate templates for:

- homepage layout
- external game catalog page
- single local game page
- header and footer layout

---

## Security and Data Handling

The project applies several WordPress-oriented safety practices:

- the RAWG API key is read from a private constant and should not be committed to the repository
- meta box saving is protected with nonce verification
- autosaves and post revisions are ignored during metadata saving
- user capability is checked before updating post metadata
- numeric game-time values are normalized with `absint()`
- dynamic output is escaped with WordPress escaping functions such as `esc_html()`, `esc_url()`, and `esc_attr()`
- external RAWG links use `target="_blank"` together with `rel="noopener noreferrer"`
- API failures return safe empty data or cached fallback data instead of exposing raw errors on the frontend

---

## Pages and Templates

### Homepage — `index.php`

The homepage includes:

- hero section
- primary call-to-action linking to the `All Games` page
- visual search section prepared for future functionality
- selected local `game` posts loaded with `WP_Query`

The search form is currently a UI element only and is not yet connected to dynamic RAWG search.

### All Games Page — `page-all-games.php`

The `All Games` page displays RAWG API results in a responsive card grid.

Each card can show:

- game image or fallback placeholder
- game title
- release date
- RAWG rating
- genres
- external RAWG details link

The page uses WordPress `paginate_links()` for catalog pagination.

### Single Game Page — `single-game.php`

The single game template displays locally managed WordPress `game` posts with:

- title
- featured image
- Main Story hours
- Completionist hours
- post content

### Header and Footer

The header includes GameTracker branding and navigation. Some navigation items, such as `My Backlog`, `Stats`, and `Login`, are placeholders for planned features.

The footer displays a short project message and uses the current year dynamically.

---

## Project Structure

```text
GameTracker/
├── assets/
│   ├── css/
│   │   └── main.css
│   ├── images/
│   │   └── placeholder.jpg
│   ├── js/
│   │   └── main.js
│   └── screenshots/
│       ├── all_games_page.png
│       └── home_page.png
├── inc/
│   └── .gitkeep
├── template-parts/
│   └── .gitkeep
├── footer.php
├── functions.php
├── header.php
├── index.php
├── page-all-games.php
├── single-game.php
├── style.css
└── README.md
```

`style.css` contains the WordPress theme metadata. The main visual styling is handled in `assets/css/main.css`.

---

## Local Setup

### Requirements

- Local WordPress environment, for example LocalWP, XAMPP, Laragon, Docker, or a standard local server setup
- PHP version compatible with your WordPress installation
- RAWG API key

### Installation

1. Clone the repository:

```bash
git clone https://github.com/macus450-crypto/GameTracker.git
```

2. Move or copy the project folder into your WordPress themes directory:

```text
wp-content/themes/GameTracker/
```

3. Add your RAWG API key in `wp-config.php` or another private local configuration file:

```php
define('RAWG_API_KEY', 'your_rawg_api_key_here');
```

4. Activate the theme in the WordPress admin panel:

```text
Appearance → Themes → GameTracker → Activate
```

5. Create a WordPress page called `All Games`.

6. Assign the `All Games Page` template to that page.

7. Refresh permalinks:

```text
Settings → Permalinks → Save Changes
```

8. Add a few local `game` posts in the WordPress admin panel to test the homepage and single game template.

---

## Current Status

GameTracker is currently a functional portfolio MVP.

Implemented:

- custom WordPress theme
- custom `game` post type
- custom game-time metadata
- admin meta box for completion times
- local game display on the homepage
- single game template
- RAWG API catalog page
- API pagination
- API response caching
- fallback to the last successful API response
- responsive dark UI

Not implemented yet as production features:

- user accounts
- real personal backlog system
- login/register flow
- user-specific game statuses
- internal user rating system
- reviews or comments
- working frontend search form
- advanced filtering UI
- internal detail pages for RAWG games
- dashboard/statistics logic

---

## Roadmap

Planned improvements:

- connect the homepage search UI to RAWG API search
- add genre, platform, rating, and ordering filters
- build internal RAWG game detail pages
- add user registration and login
- create personal backlog functionality
- add game statuses such as planned, playing, completed, and dropped
- add user ratings or short reviews
- improve empty states and API error messages
- add loading states for API-driven views
- improve accessibility and keyboard navigation
- split larger logic from `functions.php` into files under `/inc`
- add reusable template parts
- add automated checks or tests for key helper functions

---

## Purpose

GameTracker was created to show how WordPress can be used as a foundation for a custom, data-driven web application rather than only a traditional content website.

The project demonstrates the ability to combine CMS-managed content, external API data, caching, custom templates, and safer PHP handling into one coherent portfolio application.
