# GameTracker

## Project Overview
<<<<<<< HEAD
GameTracker is a WordPress-based web application for managing a gaming backlog.  
It allows users to browse games, view details, and (in future versions) manage their personal collection, ratings, and progress.

This project is built as a portfolio application focused on real-world development practices such as API integration, performance optimization, and scalable architecture.

---

## Key Technical Features

- Integration with external API (RAWG) using WordPress HTTP API (`wp_remote_get`)
- Server-side caching with WordPress Transients API (performance optimization)
- Dynamic query building using `add_query_arg()`
- Secure API key handling (excluded from repository)
- Custom Post Type (`game`) with dedicated templates
- Pagination system using `WP_Query` and `paginate_links()`
- Custom WordPress theme structure

---

## How It Works

1. User opens the "All Games" page
2. Application checks if data exists in cache (transients)
3. If cached → data is returned instantly (no API call)
4. If not cached → request is sent to RAWG API
5. Response is stored in cache for a defined time
6. Data is rendered using custom WordPress templates

This approach reduces API calls and significantly improves performance.

---

## Current Features

- Custom WordPress theme
- Homepage layout (gaming-style UI)
- "All Games" page with dynamic data
- Single Game page template
- External API integration (RAWG)
- Basic caching system

---

## Planned Features

- Search system (API-based filtering)
- User accounts (authentication)
- Game rating system (1–5 stars per user)
- Comments and reviews
- Personal backlog system
- Advanced filtering (platforms, genres, popularity)

---

## Tech Stack

- **CMS:** WordPress
- **Backend:** PHP
- **Frontend:** HTML, CSS, JavaScript
- **API:** RAWG Video Games Database API
- **Data Handling:** WordPress Transients API (caching)

---

## Project Structure (simplified)

GameTracker/
│
├── functions.php # Core logic (API, hooks, setup)
├── single-game.php # Single game template
├── page-all-games.php # Games listing page
├── assets/ # CSS / JS
└── README.md
=======
GameTracker is a comprehensive application designed to help users track their gaming statistics and achievements across multiple platforms. It provides a user-friendly interface to monitor your progress and compare it with friends.

## Features
- **User Accounts:** Create and manage your personal accounts.
- **Game Tracking:** Keep track of hours played, achievements earned, and levels completed.
- **Friends Comparison:** View and compare your statistics with friends.
- **Cross-Platform Support:** Track games across various gaming platforms.
- **Customizable Profiles:** Customize your gaming profile as per your preference.

## Tech Stack
- **Frontend:** React.js
- **Backend:** Node.js with Express
- **Database:** MongoDB
- **Authentication:** JWT (JSON Web Tokens)
- **Styling:** CSS and Material-UI

## Installation Instructions
1. Clone the repository.
   ```bash
   git clone https://github.com/macus450-crypto/GameTracker.git
   cd GameTracker
   ```
2. Install dependencies.
   ```bash
   npm install
   ```
3. Set up environment variables.
4. Start the application.
   ```bash
   npm start
   ```

## Project Structure
```
GameTracker/
|-- client/               # Frontend code
|-- server/               # Backend code
|-- README.md             # Project documentation
|-- package.json          # Node.js dependencies
```  

## Contribution Guidelines
We welcome contributions from the community! Please follow the steps below:
1. Fork the repository.
2. Create a new branch for your feature or bug fix.
3. Make your changes and commit them with clear messages.
4. Push your changes to your fork.
5. Submit a pull request detailing your changes.

Thank you for contributing!  

## License
This project is licensed under the MIT License.
>>>>>>> 358b11d916bbc32457c5da5b7568e6c41a475169
