import { useTranslation } from 'react-i18next'

export default function LanguageSwitcher() {
  const { i18n } = useTranslation()

  const languages = [
    { code: 'ru', label: 'RU' },
    { code: 'tg', label: 'TG' },
    { code: 'en', label: 'EN' },
  ]

  return (
    <div className="flex items-center space-x-1">
      {languages.map((lang) => (
        <button
          key={lang.code}
          onClick={() => i18n.changeLanguage(lang.code)}
          className={`px-2 py-1 text-xs rounded transition-colors ${
            i18n.language === lang.code
              ? 'bg-primary-500 text-white'
              : 'text-gray-400 hover:text-white hover:bg-white/10'
          }`}
        >
          {lang.label}
        </button>
      ))}
    </div>
  )
}
