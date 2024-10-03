Here is the updated `README.md` file for your **NoticeBoard** project, incorporating the admin creation and updated table structure:

---

# NoticeBoard

A dynamic notice board web application built using PHP, HTML, CSS, JavaScript, and SQL. This application allows administrators to manage notices by adding, editing, and deleting them, while users can view, filter, and search for notices based on categories and tags like semesters, sports, or extra-curricular activities.

## Table of Contents
- [Features](#features)
- [Technologies Used](#technologies-used)
- [Installation](#installation)
- [Database Schema](#database-schema)
- [Usage](#usage)
- [Admin Setup](#admin-setup)
- [Screenshots](#screenshots)
- [Contributing](#contributing)


## Features

- **Admin Panel**: 
  - Admin can log in to manage notices (create, edit, delete).
  - Secure admin access with a login system.
  - Admin can upload files (images/PDFs) for notices.
  
- **Notice Display**: 
  - Users can view notices without logging in.
  - Filter notices by categories and tags such as semesters, sports, or extra-curricular.
  - Search functionality for notices.

- **Responsive Design**: 
  - Fully responsive design with a Pinterest-like grid layout for notices.
  
- **File Uploads**: 
  - Notices support file attachments (images, PDFs).
  
- **Tags & Categories**: 
  - Notices can be tagged for easy filtering.
  - Predefined tags such as "Semester 1-8," "Sports," and "Extra Curricular."

## Technologies Used

- **Frontend**: 
  - HTML5
  - CSS3
  - JavaScript
  
- **Backend**: 
  - PHP
  - MySQL
  
- **Development Environment**: 
  - Visual Studio Code
  - XAMPP / WAMP (for local PHP and MySQL server)

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/yourusername/NoticeBoard.git
   ```

2. Set up the database:

   - Import the provided SQL schema and seed data into your MySQL database from Table Genration:

    
3. Configure the database connection:

   - Update the `config.php` file with your database credentials:

     ```php
     <?php
     $servername = "localhost";
     $username = "root";
     $password = ""; // If no password, leave blank
     $dbname = "notice_board";
     ?>
     ```

4. Run the application:

   - Start your local server (XAMPP or WAMP).
   - Open the project folder in your server’s `htdocs` directory.
   - Access the application by visiting `http://localhost/NoticeBoard` in your browser.

## Database Schema

### `admins`
| Field       | Type          | Description                     |
|-------------|---------------|---------------------------------|
| AdminId     | INT (Primary Key, Auto Increment) | Admin ID |
| Username    | VARCHAR(100)   | Admin username (Unique)         |
| Password    | VARCHAR(255)   | Admin password (hashed)         |
| Email       | VARCHAR(100)   | Admin email address (Unique)    |

### `notices`
| Field       | Type          | Description                     |
|-------------|---------------|---------------------------------|
| NoticeId    | INT (Primary Key, Auto Increment) | Notice ID |
| Title       | VARCHAR(255)   | Notice title                    |
| Description | TEXT           | Notice description              |
| FilePath    | VARCHAR(255)   | Path to attached file (image/PDF) |
| Category    | VARCHAR(100)   | Notice category (e.g., Semester) |
| Tags        | VARCHAR(255)   | Associated tags                 |
| CreatedAt   | TIMESTAMP      | Date and time of notice creation |
| AdminId     | INT            | Admin who created the notice    |

### `tags`
| Field       | Type          | Description                     |
|-------------|---------------|---------------------------------|
| TagId       | INT (Primary Key, Auto Increment) | Tag ID    |
| Name        | VARCHAR(100)   | Tag name (Unique)               |

### `notice_tags`
| Field       | Type          | Description                     |
|-------------|---------------|---------------------------------|
| NoticeId    | INT            | Foreign key referencing `notices` |
| TagId       | INT            | Foreign key referencing `tags`    |
| PRIMARY KEY | (NoticeId, TagId) | Composite key                |

## Usage

### Admin
1. **Login**: Go to the admin login page and log in using your credentials.
2. **Create Notice**: Admin can create notices with title, description, file attachments, and tags.
3. **Edit/Delete Notice**: Admin can manage existing notices from the admin panel.
4. **Logout**: Admin can log out securely using the logout button.

### Users
- View notices on the home page.
- Filter notices by categories and tags (e.g., Semester 1-8, Sports).
- Search for notices using keywords.

## Admin Setup

To add an admin, run the add_admin.php


## Screenshots


## Contributing

1. Fork the project
#   N o t i c e B o a r d  
 