# INNOVA.TJ - Platform of Innovation and Commercialisation

**Platform of Innovation and Commercialisation of Science Developments (PICSD)**

Платформа коммерциализации результатов научной и научно-технической деятельности Республики Таджикистан.

## 📋 Описание

Единая национальная цифровая платформа для:
- Коммерциализации научных разработок
- Взаимодействия ученых, университетов, НИИ и инвесторов
- Привлечения инвестиций в научные проекты
- Популяризации науки и инноваций
- Формирования инновационной экосистемы Республики Таджикистан

## 🚀 Технологии

### Frontend
- **React 18** с TypeScript
- **Vite** - сборка проекта
- **TailwindCSS** - стилизация
- **Framer Motion** - анимации
- **Three.js / React Three Fiber** - 3D графика
- **GSAP** - scroll-анимации
- **i18next** - интернационализация (RU/TG/EN)
- **React Router** - роутинг
- **Zustand** - state management

### Backend
- **Laravel 12** (PHP 8.4)
- **MySQL 8** - база данных
- **Redis** - кэш и очереди
- **Laravel Sanctum** - API аутентификация
- **Laravel Socialite** - OAuth (Google)
- **Spatie Permission** - RBAC

## 📁 Структура проекта

```
/workspace
├── frontend/          # React приложение
│   ├── src/
│   │   ├── components/    # UI компоненты
│   │   ├── pages/         # Страницы приложения
│   │   ├── hooks/         # Custom hooks
│   │   ├── stores/        # Zustand stores
│   │   ├── i18n/          # Локализация
│   │   ├── styles/        # Глобальные стили
│   │   └── types/         # TypeScript типы
│   ├── package.json
│   └── vite.config.ts
│
└── backend/           # Laravel API
    ├── app/
    │   ├── Models/        # Eloquent модели
    │   └── Http/          # Контроллеры, Middleware
    ├── database/
    │   └── migrations/    # Миграции БД
    ├── routes/            # API роуты
    └── composer.json
```

## 🔧 Установка и запуск

### Frontend

```bash
cd /workspace/frontend
npm install
npm run dev
```

Приложение будет доступно по адресу: http://localhost:3000

### Backend

```bash
cd /workspace/backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

API будет доступно по адресу: http://localhost:8000

## 👥 Роли пользователей

- **USER** - базовый пользователь (просмотр)
- **SCIENTIST** - учёный (публикация разработок)
- **UNIVERSITY** - университет (управление учёными и разработками)
- **NII** - НИИ (научно-исследовательский институт)
- **INVESTOR** - инвестор (поиск и финансирование проектов)
- **ADMIN** - администратор (полный контроль)

## 🌐 Многоязычность

Поддержка трёх языков:
- 🇷🇺 Русский
- 🇹🇯 Таджикский
- 🇬🇧 English

Переключение языка без перезагрузки страницы.

## 🎨 Дизайн

Стиль: Минимализм (Apple + Tesla + OpenAI)
- Glassmorphism эффекты
- 3D элементы и Parallax
- Smooth Scroll анимации
- Particles фон
- Градиенты
- Micro-анимации
- Dark/Light режим

## 📄 Лицензия

© 2024 INNOVA.TJ. Все права защищены.
