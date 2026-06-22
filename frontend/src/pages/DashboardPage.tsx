import { useTranslation } from 'react-i18next'

export default function DashboardPage() {
  const { t } = useTranslation()
  
  return (
    <div className="min-h-screen py-12 px-4">
      <div className="max-w-7xl mx-auto">
        <h1 className="text-4xl font-bold mb-8 gradient-text">{t('nav.dashboard')}</h1>
        <div className="glass card p-8 text-center">
          <p className="text-gray-300 mb-4">Панель управления</p>
          <p className="text-sm text-gray-400">Функционал будет добавлен в следующей версии</p>
        </div>
      </div>
    </div>
  )
}
