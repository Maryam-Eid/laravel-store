# Laravel Store Project

Welcome to the Laravel Store project! This web application is built using the Laravel PHP framework and is designed to
serve as a basic online store.

## Features

- User Authentication: Allow users to register, log in, and manage their accounts.
- Product Management: Admins can add, edit, and delete products.
- Shopping Cart: Users can add products to their shopping cart and proceed to checkout.
- Orders: View order history and details of past purchases.
- Categories: Organize products into different categories for easy navigation.

## Getting Started

To get started with this project, follow these steps:

1. **Clone the repository:**
   ```bash
   git clone https://github.com/maryam-eid/laravel-store.git

2. **Install Dependencies:**
   ```bash
    composer install

3. **Create a copy of the '.env' file:**
   ```bash
    cp .env.example .env

4. **Generate Application Key:**
   ```bash
    php artisan key:generate

5. **Configure Database:**

- Open '.env' file and set your database credentials.
- Run migrations: 'php artisan migrate'

6. **Start the Development Server:**
   ```bash
    php artisan serve

Visit [http://localhost:8000](http://localhost:8000) in your browser to access the application.


## Contributing

If you'd like to contribute to the project, please follow the standard Git workflow:
1. Fork the repository.
2. Create a new branch: 'git checkout -b feature/new-feature'.
3. Make your changes and commit them: 'git commit -m 'Add new feature'.
4. Push to the branch: 'git push origin feature/new-feature'.
5. Create a pull request.


## Issues

If you encounter any issues or have suggestions, please open an issue on the [Issues](https://github.com/maryam-eid/laravel-store/issues) tab.
