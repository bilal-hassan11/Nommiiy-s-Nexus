# Affiliate Web Application

This project is a web application built using **Laravel** (as a backend API) and **Vue.js** (as the frontend). This guide will walk you through setting up and running the project locally.

---

## 🚀 Tech Stack

- **Backend**: Laravel (REST API)
- **Frontend**: Vue.js
- **Database**: MySQL (default), but configurable
- **Package Manager**: Composer (PHP), NPM/Yarn (JS)

---

## 📁 Project Structure

```
project-root/
├── backend/            # Laravel project
│   ├── app/
│   ├── routes/
│   └── ...
├── frontend/           # Vue.js project
│   ├── src/
│   ├── public/
│   └── ...
└── README.md
```

---

## 🔧 Prerequisites

Make sure you have the following installed on your machine:

- PHP >= 8.1
- Composer
- Node.js >= 16.x
- NPM or Yarn
- MySQL (or any supported database)
- Git

---

## 🛠️ Setup Instructions

### 📦 Backend (Laravel)

1. Navigate to the backend directory:
   ```bash
   cd backend
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Copy `.env` file and set up your environment:
   ```bash
   cp .env.example .env
   ```

4. Generate the application key:
   ```bash
   php artisan key:generate
   ```

5. Configure database settings in `.env`, then run migrations:
   ```bash
   php artisan migrate
   ```

6. (Optional) Seed database:
   ```bash
   php artisan db:seed
   ```

7. Run the Laravel development server:
   ```bash
   php artisan serve
   ```

The API should now be running at `http://127.0.0.1:8000`.

---

### 🌐 Frontend (Vue.js)

1. Navigate to the frontend directory:
   ```bash
   cd ../frontend
   ```

2. Install JavaScript dependencies:
   ```bash
   npm install
   # or
   yarn install
   ```

3. Start the development server:
   ```bash
   npm run dev
   # or
   yarn dev
   ```

By default, Vue should be running at `http://localhost:5173`.

---

## 🔐 API Authentication

If you're using Laravel Sanctum or Passport, follow the specific setup in `backend/README.md` or your auth guide.

---

## 📝 Environment Variables

Ensure both frontend and backend `.env` files are properly configured. The frontend may need the backend API base URL, e.g.:

```env
# frontend/.env
VITE_API_URL=http://127.0.0.1:8000/api
```

---

## ⚙️ Useful Commands

- **Clear Laravel Cache**: `php artisan optimize:clear`
- **Lint Vue code**: `npm run lint`
- **Build Vue for Production**: `npm run build`

---

## 📦 Production Setup

For production, ensure:
- Laravel is served via Apache/Nginx with a proper `public` directory.
- Vue is built (`npm run build`) and served via a web server or integrated into Laravel using Vite.
- Environment variables are configured correctly.

---

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/my-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin feature/my-feature`)
5. Open a pull request

---

## 🧾 License

This project is licensed under the MIT License.

---

## 📬 Contact

For questions or support, please contact the project maintainers.
