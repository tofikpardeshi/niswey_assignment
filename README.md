# PHP Laravel Contacts CRUD Application

This is a PHP Laravel-based CRUD application for managing contacts. It supports bulk import of contacts using XML files.

## Features

-   Create, Read, Update, and Delete (CRUD) operations for contacts.
-   Bulk import contacts using XML.
-   User-friendly interface.
-   Validate duplicate contacts by phone number.

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/tofikpardeshi/niswey_assignment.git
cd contact_assignment
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Configure Environment Variables

Update the database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_contacts
DB_USERNAME=root
DB_PASSWORD=""
```

### 4. Run Migrations

```bash
php artisan migrate
```

### 5. Serve the Application

```bash
php artisan serve
npm run dev
```

## Authntication (Login Credentials)

-   Email: admin@yopmail.com
-   Password: Pass@123

-   Email: tofik@yopmail.com
-   Password: Pass@123

## Bulk Import XML

-   Users can upload an XML file containing multiple contacts.
-   The XML should follow this format:

```xml
<contacts>
    <contact>
       <name>Kökten</name>
       <lastName>Adal</lastName>
       <phone>+90 333 8859342</phone>
    </contact>
</contacts>
```
