import { Link } from 'react-router-dom'

export default function NotFoundPage() {
  return (
    <div className="min-h-screen flex items-center justify-center px-4">
      <div className="text-center">
        <h1 className="text-6xl font-bold gradient-text mb-4">404</h1>
        <p className="text-xl text-gray-300 mb-8">Страница не найдена</p>
        <Link to="/" className="btn-primary">
          На главную
        </Link>
      </div>
    </div>
  )
}
