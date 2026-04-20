# 🎮 GameTracker

GameTracker is a custom WordPress-based web application for browsing and managing a video game library.
The project focuses on integrating external APIs, optimizing performance with caching, and building a scalable structure using WordPress as a backend.

---

## 🚀 Features

* 🔍 Browse games fetched from external API (RAWG)
* ⚡ API data caching using WordPress Transients (performance optimization)
* 📄 Custom post type: **Games**
* 🧩 Custom templates:

  * All Games page (pagination)
  * Single Game page
* 🖼️ Game cards with image, title, and details
* 📚 Pagination system (custom WP_Query implementation)

---

## 🧠 Key Concepts Used

This project is not based on plugins – it focuses on **custom development**.

* WordPress Theme Development
* Custom Post Types (CPT)
* WP_Query (custom loops & pagination)
* External API Integration (RAWG)
* Caching with `set_transient()`
* Clean PHP structure inside WordPress

---

## 🌐 API Integration

Game data is fetched dynamically from the RAWG API.

* Request handling using `wp_remote_get()`
* Query parameters (pagination, search, filters)
* Response parsing (`json_decode`)
* Performance optimization via caching

Example logic:

```php
$cached_data = get_transient($transient_key);

if ($cached_data !== false) {
    return $cached_data;
}
```

---

## ⚡ Performance Optimization

To reduce API calls and improve speed:

* Transient caching is used (`HOUR_IN_SECONDS`)
* Unique cache keys based on query parameters
* Avoids unnecessary external requests

---

## 📁 Project Structure (simplified)

```
/theme
  ├── functions.php        # API logic + hooks
  ├── page-all-games.php   # All games view
  ├── single-game.php      # Single game page
  ├── style.css
```

---

## 🛠️ Technologies

* WordPress (Custom Theme)
* PHP
* JavaScript (basic DOM)
* HTML / CSS

---

## 🎯 Purpose of the Project

This project was built to:

* Learn real-world API integration
* Understand WordPress beyond plugins
* Practice performance optimization

---

## 🔮 Future Improvements

* 🔐 User accounts & authentication
* ⭐ Game rating system
* 💬 Comments system
* 📦 Personal game backlog
* 🔎 Advanced filtering & search

---

## 📸 Screenshots

![home_page](assets/screenshots/home_page.png)
![all_games_page](assets/screenshots/all_games_page.png)

---

## ⚠️ Notes

API key is stored outside the repository for security reasons.
