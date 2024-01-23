# Webdev-Project

## Overview
This project is the culminating assignment for my web development 1 course, designed around the concept of a task manager similar to Trello. Utilizing PHP and the MVC (Model-View-Controller) design pattern, the application offers a dynamic and user-friendly platform for task management and organization. You can see the demo [here](https://tasks.maxkruiswegt.com/).

## Key Features
- **Comprehensive Task Management**: Users have the ability to create, read, update, and delete tasks organized as cards, providing a complete management system for their activities.
- **Board and List Organization**: The application allows users to structure their tasks within boards and lists, offering a multi-layered approach to organize their work. Each board can contain multiple lists, and each list can house numerous tasks (cards), enabling a detailed and hierarchical structuring of tasks.
- **User-Specific Boards**: Boards are linked to individual user accounts, ensuring a personalized and secure experience. Users can manage their own boards, which are uniquely associated with their account, providing a user-centric task management environment.
- **User Authentication**: The application features a secure login and registration system, allowing users to access their personalized boards and tasks with confidence.
- **Responsive Design**: Designed for responsiveness and accessibility, the application ensures a seamless experience across various devices and screen sizes.

## Technology Stack
- **Front-End**: HTML, CSS, JavaScript
- **Back-End**: PHP, utilizing the MVC design pattern
- **Database**: MariaDB (a GPL MySQL fork)
- **Server**: NGINX, PHP FastCGI Process Manager with PDO MySQL support
- **Containerization**: Docker for easy deployment and environment management

## Installation
1. Install Docker Desktop (Windows/Mac) or Docker Engine (Linux).
2. Clone the project repository.

## Usage
### To run the application:
1. Open a terminal.
2. Navigate to the project directory.
3. Run the following command: `docker compose up`
4. Visit [localhost](http://localhost) in your browser to access the application.
5. PHPMyAdmin is accessible on [localhost:8080](http://localhost:8080).
<br></br>

### To stop the application:
1. Open a terminal.
2. Navigate to the project directory.
3. Run the following command: `docker compose down`
