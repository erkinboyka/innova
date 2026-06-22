import i18n from 'i18next'
import { initReactI18next } from 'react-i18next'

const resources = {
  en: {
    translation: {
      nav: {
        home: 'Home',
        developments: 'Developments',
        marketplace: 'Marketplace',
        grants: 'Grants',
        events: 'Events',
        login: 'Login',
        dashboard: 'Dashboard',
        profile: 'Profile'
      },
      hero: {
        title: 'INNOVA.TJ',
        subtitle: 'Platform of Innovation and Commercialisation of Science Developments',
        slogan: 'Innovate Today, Transform Tomorrow',
        cta: 'Explore Innovations'
      },
      journey: {
        title: 'From Challenges to Innovation',
        year1991: '1991 - Rebuilding',
        revival: 'Revival',
        development: 'Development',
        education: 'Education',
        science: 'Science',
        innovations: 'Innovations',
        digitalization: 'Digitalization',
        year2026: '2026 - Future',
        future: 'The Future of Tajikistan'
      },
      auth: {
        loginTitle: 'Welcome Back',
        email: 'Email',
        password: 'Password',
        phone: 'Phone Number',
        phonePlaceholder: '+992 __ ___ __ __',
        loginButton: 'Sign In',
        googleLogin: 'Continue with Google',
        smsCode: 'SMS Code',
        verify: 'Verify',
        noAccount: "Don't have an account?",
        signup: 'Sign Up'
      },
      roles: {
        user: 'User',
        scientist: 'Scientist',
        university: 'University',
        nii: 'Research Institute',
        investor: 'Investor',
        admin: 'Administrator'
      },
      categories: {
        medicine: 'Medicine',
        ai: 'Artificial Intelligence',
        education: 'Education',
        chemistry: 'Chemistry',
        physics: 'Physics',
        biology: 'Biology',
        energy: 'Energy',
        robotics: 'Robotics',
        space: 'Space Technology',
        ecology: 'Ecology'
      },
      development: {
        title: 'Scientific Developments',
        search: 'Search developments...',
        filter: 'Filter by Category',
        trl: 'TRL',
        status: 'Status',
        author: 'Author',
        investment: 'Investment Goal',
        roi: 'ROI',
        invest: 'Invest Now',
        statuses: {
          research: 'Research',
          prototype: 'Prototype',
          ready: 'Ready',
          commercialized: 'Commercialized'
        }
      },
      grants: {
        title: 'Grants & Programs',
        organizer: 'Organizer',
        amount: 'Amount',
        deadline: 'Deadline',
        requirements: 'Requirements',
        apply: 'Apply Now',
        status: 'Status'
      },
      events: {
        title: 'Events & News',
        conferences: 'Conferences',
        exhibitions: 'Exhibitions',
        forums: 'Forums',
        competitions: 'Competitions',
        hackathons: 'Hackathons',
        news: 'News'
      },
      profile: {
        about: 'About',
        research: 'Research',
        patents: 'Patents',
        articles: 'Articles',
        projects: 'Projects',
        videos: 'Videos',
        contacts: 'Contacts',
        achievements: 'Achievements',
        awards: 'Awards'
      },
      common: {
        loading: 'Loading...',
        error: 'Error',
        success: 'Success',
        save: 'Save',
        cancel: 'Cancel',
        delete: 'Delete',
        edit: 'Edit',
        view: 'View',
        search: 'Search...',
        noResults: 'No results found'
      }
    }
  },
  tg: {
    translation: {
      nav: {
        home: 'Асосӣ',
        developments: 'Таҳқиқот',
        marketplace: 'Бозор',
        grants: 'Грантҳо',
        events: 'Чорабиниҳо',
        login: 'Воридшавӣ',
        dashboard: 'Панел',
        profile: 'Профил'
      },
      hero: {
        title: 'INNOVA.TJ',
        subtitle: 'Платформаи навоварӣ ва тиҷоратии таҳқиқоти илмӣ',
        slogan: 'Имрӯз навоварӣ кунед, фардо тағйир диҳед',
        cta: 'Навовариҳоро бубинед'
      },
      journey: {
        title: 'Аз мушкилот то навоварӣ',
        year1991: '1991 - Барқарорсозӣ',
        revival: 'Эҳё',
        development: 'Рушд',
        education: 'Маориф',
        science: 'Илм',
        innovations: 'Навовариҳо',
        digitalization: 'Рақамикунонӣ',
        year2026: '2026 - Оянда',
        future: 'Ояндаи Тоҷикистон'
      },
      auth: {
        loginTitle: 'Хуш омадед',
        email: 'Почтаи электронӣ',
        password: 'Рамз',
        phone: 'Рақами телефон',
        phonePlaceholder: '+992 __ ___ __ __',
        loginButton: 'Ворид шудан',
        googleLogin: 'Бо Google ворид шудан',
        smsCode: 'Коди SMS',
        verify: 'Тасдиқ кардан',
        noAccount: 'Ҳисоб надоред?',
        signup: 'Сабти ном'
      },
      roles: {
        user: 'Истифодабаранда',
        scientist: 'Олим',
        university: 'Донишгоҳ',
        nii: 'Институти илмӣ',
        investor: 'Сармоягузор',
        admin: 'Маъмур'
      },
      categories: {
        medicine: 'Тиб',
        ai: 'Зеҳни сунъӣ',
        education: 'Маориф',
        chemistry: 'Кимиё',
        physics: 'Физика',
        biology: 'Биология',
        energy: 'Энергетика',
        robotics: 'Робототехника',
        space: 'Технологияҳои кайҳонӣ',
        ecology: 'Экология'
      },
      development: {
        title: 'Таҳқиқоти илмӣ',
        search: 'Ҷустуҷӯи таҳқиқот...',
        filter: 'Филтр аз рӯи категория',
        trl: 'TRL',
        status: 'Статус',
        author: 'Муаллиф',
        investment: 'Ҳадафи сармоягузорӣ',
        roi: 'ROI',
        invest: 'Сармоягузорӣ кардан',
        statuses: {
          research: 'Таҳқиқот',
          prototype: 'Прототип',
          ready: 'Омода',
          commercialized: 'Тиҷоратишуда'
        }
      },
      grants: {
        title: 'Грантҳо ва барномаҳо',
        organizer: 'Ташкилкунанда',
        amount: 'Маблағ',
        deadline: 'Муҳлат',
        requirements: 'Талабот',
        apply: 'Дархост додан',
        status: 'Статус'
      },
      events: {
        title: 'Чорабиниҳо ва хабарҳо',
        conferences: 'Конференсияҳо',
        exhibitions: 'Намоишгоҳҳо',
        forums: 'Форумҳо',
        competitions: 'Озмуна',
        hackathons: 'Хакатонҳо',
        news: 'Хабарҳо'
      },
      profile: {
        about: 'Дар бора',
        research: 'Таҳқиқот',
        patents: 'Патентҳо',
        articles: 'Мақолаҳо',
        projects: 'Лоиҳаҳо',
        videos: 'Видеоҳо',
        contacts: 'Тамос',
        achievements: 'Дастовардҳо',
        awards: 'Ҷоизаҳо'
      },
      common: {
        loading: 'Боркунӣ...',
        error: 'Хатогӣ',
        success: 'Муваффақ',
        save: 'Захира кардан',
        cancel: 'Бекор кардан',
        delete: 'Нест кардан',
        edit: 'Таҳрир кардан',
        view: 'Дидан',
        search: 'Ҷустуҷӯ...',
        noResults: 'Натиҷа ёфт нашуд'
      }
    }
  },
  ru: {
    translation: {
      nav: {
        home: 'Главная',
        developments: 'Разработки',
        marketplace: 'Маркетплейс',
        grants: 'Гранты',
        events: 'События',
        login: 'Вход',
        dashboard: 'Панель',
        profile: 'Профиль'
      },
      hero: {
        title: 'INNOVA.TJ',
        subtitle: 'Платформа инноваций и коммерциализации научных разработок',
        slogan: 'Инновируй сегодня, преобразуй завтра',
        cta: 'Изучить инновации'
      },
      journey: {
        title: 'От трудностей к инновациям',
        year1991: '1991 - Восстановление',
        revival: 'Возрождение',
        development: 'Развитие',
        education: 'Образование',
        science: 'Наука',
        innovations: 'Инновации',
        digitalization: 'Цифровизация',
        year2026: '2026 - Будущее',
        future: 'Будущее Таджикистана'
      },
      auth: {
        loginTitle: 'С возвращением',
        email: 'Email',
        password: 'Пароль',
        phone: 'Номер телефона',
        phonePlaceholder: '+992 __ ___ __ __',
        loginButton: 'Войти',
        googleLogin: 'Войти через Google',
        smsCode: 'SMS код',
        verify: 'Подтвердить',
        noAccount: 'Нет аккаунта?',
        signup: 'Зарегистрироваться'
      },
      roles: {
        user: 'Пользователь',
        scientist: 'Учёный',
        university: 'Университет',
        nii: 'НИИ',
        investor: 'Инвестор',
        admin: 'Администратор'
      },
      categories: {
        medicine: 'Медицина',
        ai: 'Искусственный интеллект',
        education: 'Образование',
        chemistry: 'Химия',
        physics: 'Физика',
        biology: 'Биология',
        energy: 'Энергетика',
        robotics: 'Робототехника',
        space: 'Космические технологии',
        ecology: 'Экология'
      },
      development: {
        title: 'Научные разработки',
        search: 'Поиск разработок...',
        filter: 'Фильтр по категории',
        trl: 'TRL',
        status: 'Статус',
        author: 'Автор',
        investment: 'Цель инвестиций',
        roi: 'ROI',
        invest: 'Инвестировать',
        statuses: {
          research: 'Исследование',
          prototype: 'Прототип',
          ready: 'Готово',
          commercialized: 'Коммерциализировано'
        }
      },
      grants: {
        title: 'Гранты и программы',
        organizer: 'Организатор',
        amount: 'Сумма',
        deadline: 'Срок подачи',
        requirements: 'Требования',
        apply: 'Подать заявку',
        status: 'Статус'
      },
      events: {
        title: 'События и новости',
        conferences: 'Конференции',
        exhibitions: 'Выставки',
        forums: 'Форумы',
        competitions: 'Конкурсы',
        hackathons: 'Хакатоны',
        news: 'Новости'
      },
      profile: {
        about: 'О себе',
        research: 'Исследования',
        patents: 'Патенты',
        articles: 'Статьи',
        projects: 'Проекты',
        videos: 'Видео',
        contacts: 'Контакты',
        achievements: 'Достижения',
        awards: 'Награды'
      },
      common: {
        loading: 'Загрузка...',
        error: 'Ошибка',
        success: 'Успешно',
        save: 'Сохранить',
        cancel: 'Отмена',
        delete: 'Удалить',
        edit: 'Редактировать',
        view: 'Просмотр',
        search: 'Поиск...',
        noResults: 'Результатов не найдено'
      }
    }
  }
}

i18n
  .use(initReactI18next)
  .init({
    resources,
    lng: 'ru',
    fallbackLng: 'en',
    interpolation: {
      escapeValue: false
    }
  })

export default i18n
