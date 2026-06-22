import { Outlet, Link, useLocation } from 'react-router-dom'
import { useTranslation } from 'react-i18next'
import { useState } from 'react'
import LanguageSwitcher from './LanguageSwitcher'
import ThemeToggle from './ThemeToggle'

export default function Layout() {
  const { t } = useTranslation()
  const location = useLocation()
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false)

  const navItems = [
    { path: '/', label: t('nav.home') },
    { path: '/developments', label: t('nav.developments') },
    { path: '/marketplace', label: t('nav.marketplace') },
    { path: '/grants', label: t('nav.grants') },
    { path: '/events', label: t('nav.events') },
  ]

  return (
    <div className="min-h-screen gradient-bg text-white">
      {/* Navigation */}
      <nav className="fixed top-0 left-0 right-0 z-50 glass border-b border-white/10">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex items-center justify-between h-16">
            {/* Logo */}
            <Link to="/" className="flex items-center space-x-2">
              <span className="text-2xl font-bold gradient-text">INNOVA.TJ</span>
            </Link>

            {/* Desktop Navigation */}
            <div className="hidden md:flex items-center space-x-8">
              {navItems.map((item) => (
                <Link
                  key={item.path}
                  to={item.path}
                  className={`text-sm font-medium transition-colors duration-200 ${
                    location.pathname === item.path
                      ? 'text-primary-400'
                      : 'text-gray-300 hover:text-white'
                  }`}
                >
                  {item.label}
                </Link>
              ))}
            </div>

            {/* Right side */}
            <div className="flex items-center space-x-4">
              <LanguageSwitcher />
              <ThemeToggle />
              <Link
                to="/login"
                className="hidden md:block btn-secondary text-sm"
              >
                {t('nav.login')}
              </Link>
              
              {/* Mobile menu button */}
              <button
                onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
                className="md:hidden p-2 rounded-lg glass"
              >
                <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  {mobileMenuOpen ? (
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                  ) : (
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                  )}
                </svg>
              </button>
            </div>
          </div>
        </div>

        {/* Mobile menu */}
        {mobileMenuOpen && (
          <div className="md:hidden glass border-t border-white/10">
            <div className="px-4 py-4 space-y-2">
              {navItems.map((item) => (
                <Link
                  key={item.path}
                  to={item.path}
                  onClick={() => setMobileMenuOpen(false)}
                  className="block px-4 py-2 text-gray-300 hover:text-white hover:bg-white/10 rounded-lg"
                >
                  {item.label}
                </Link>
              ))}
              <Link
                to="/login"
                className="block px-4 py-2 btn-primary text-center rounded-lg mt-4"
              >
                {t('nav.login')}
              </Link>
            </div>
          </div>
        )}
      </nav>

      {/* Main Content */}
      <main className="pt-16">
        <Outlet />
      </main>

      {/* Footer */}
      <footer className="glass-dark border-t border-white/10 mt-20">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
          <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
              <h3 className="text-xl font-bold gradient-text mb-4">INNOVA.TJ</h3>
              <p className="text-gray-400 text-sm">
                Platform of Innovation and Commercialisation of Science Developments
              </p>
            </div>
            <div>
              <h4 className="font-semibold mb-4">{t('nav.developments')}</h4>
              <ul className="space-y-2 text-gray-400 text-sm">
                <li><Link to="/marketplace" className="hover:text-white">Marketplace</Link></li>
                <li><Link to="/grants" className="hover:text-white">Grants</Link></li>
              </ul>
            </div>
            <div>
              <h4 className="font-semibold mb-4">{t('nav.events')}</h4>
              <ul className="space-y-2 text-gray-400 text-sm">
                <li><Link to="/events" className="hover:text-white">Conferences</Link></li>
                <li><Link to="/events" className="hover:text-white">Hackathons</Link></li>
              </ul>
            </div>
            <div>
              <h4 className="font-semibold mb-4">Contact</h4>
              <ul className="space-y-2 text-gray-400 text-sm">
                <li>info@innova.tj</li>
                <li>+992 00 000 0000</li>
              </ul>
            </div>
          </div>
          <div className="border-t border-white/10 mt-8 pt-8 text-center text-gray-400 text-sm">
            © 2024 INNOVA.TJ. All rights reserved.
          </div>
        </div>
      </footer>
    </div>
  )
}
