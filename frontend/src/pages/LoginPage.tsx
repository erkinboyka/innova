import { useTranslation } from 'react-i18next'
import { useState } from 'react'
import { Link, useNavigate } from 'react-router-dom'
import { useAuthStore } from '../../stores/authStore'

export default function LoginPage() {
  const { t } = useTranslation()
  const navigate = useNavigate()
  const { login, loginWithPhone, isLoading } = useAuthStore()
  const [loginMethod, setLoginMethod] = useState<'email' | 'phone'>('email')
  const [formData, setFormData] = useState({
    email: '',
    password: '',
    phone: '',
    smsCode: ''
  })
  const [smsSent, setSmsSent] = useState(false)
  const [error, setError] = useState<string | null>(null)

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()
    setError(null)
    
    try {
      if (loginMethod === 'email') {
        await login(formData.email, formData.password)
      } else {
        await loginWithPhone(formData.phone, formData.smsCode)
      }
      navigate('/dashboard')
    } catch (err: any) {
      setError(err.response?.data?.message || 'Ошибка входа')
    }
  }

  const handleGoogleLogin = () => {
    // TODO: Implement Google OAuth
    console.log('Google login')
  }

  const handleSendSms = () => {
    // TODO: Implement SMS sending
    setSmsSent(true)
  }

  return (
    <div className="min-h-screen flex items-center justify-center px-4 py-12">
      <div className="w-full max-w-md">
        <div className="glass card rounded-2xl p-8">
          <h1 className="text-3xl font-bold text-center mb-2 gradient-text">
            {t('auth.loginTitle')}
          </h1>
          <p className="text-gray-400 text-center mb-8">
            INNOVA.TJ
          </p>

          {/* Login method tabs */}
          <div className="flex mb-6 bg-white/5 rounded-lg p-1">
            <button
              onClick={() => setLoginMethod('email')}
              className={`flex-1 py-2 rounded-md transition-colors ${
                loginMethod === 'email' ? 'bg-primary-500 text-white' : 'text-gray-400'
              }`}
            >
              Email
            </button>
            <button
              onClick={() => setLoginMethod('phone')}
              className={`flex-1 py-2 rounded-md transition-colors ${
                loginMethod === 'phone' ? 'bg-primary-500 text-white' : 'text-gray-400'
              }`}
            >
              {t('auth.phone')}
            </button>
          </div>

          <form onSubmit={handleSubmit} className="space-y-4">
            {loginMethod === 'email' ? (
              <>
                <div>
                  <label className="block text-sm font-medium mb-2">
                    {t('auth.email')}
                  </label>
                  <input
                    type="email"
                    value={formData.email}
                    onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                    className="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:border-primary-500 transition-colors"
                    placeholder="example@mail.com"
                    required
                  />
                </div>
                <div>
                  <label className="block text-sm font-medium mb-2">
                    {t('auth.password')}
                  </label>
                  <input
                    type="password"
                    value={formData.password}
                    onChange={(e) => setFormData({ ...formData, password: e.target.value })}
                    className="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:border-primary-500 transition-colors"
                    placeholder="••••••••"
                    required
                  />
                </div>
              </>
            ) : (
              <>
                <div>
                  <label className="block text-sm font-medium mb-2">
                    {t('auth.phone')}
                  </label>
                  <input
                    type="tel"
                    value={formData.phone}
                    onChange={(e) => setFormData({ ...formData, phone: e.target.value })}
                    className="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:border-primary-500 transition-colors"
                    placeholder={t('auth.phonePlaceholder')}
                    required
                  />
                </div>
                {!smsSent ? (
                  <button
                    type="button"
                    onClick={handleSendSms}
                    className="w-full btn-secondary"
                  >
                    Отправить код
                  </button>
                ) : (
                  <div>
                    <label className="block text-sm font-medium mb-2">
                      {t('auth.smsCode')}
                    </label>
                    <input
                      type="text"
                      value={formData.smsCode}
                      onChange={(e) => setFormData({ ...formData, smsCode: e.target.value })}
                      className="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:border-primary-500 transition-colors"
                      placeholder="______"
                      maxLength={6}
                      required
                    />
                  </div>
                )}
              </>
            )}

            <button 
              type="submit" 
              className="w-full btn-primary"
              disabled={isLoading}
            >
              {isLoading ? t('common.loading') : t('auth.loginButton')}
            </button>
          </form>

          {error && (
            <div className="mt-4 p-3 bg-red-500/20 border border-red-500/50 rounded-lg text-red-300 text-sm">
              {error}
            </div>
          )}

          {/* Divider */}
          <div className="relative my-6">
            <div className="absolute inset-0 flex items-center">
              <div className="w-full border-t border-white/10"></div>
            </div>
            <div className="relative flex justify-center text-sm">
              <span className="px-2 bg-transparent text-gray-400">или</span>
            </div>
          </div>

          {/* Google Login */}
          <button
            onClick={handleGoogleLogin}
            className="w-full flex items-center justify-center gap-3 px-4 py-3 bg-white text-gray-900 rounded-lg hover:bg-gray-100 transition-colors font-medium"
          >
            <svg className="w-5 h-5" viewBox="0 0 24 24">
              <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
              <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
              <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
              <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            {t('auth.googleLogin')}
          </button>

          {/* Sign up link */}
          <p className="mt-6 text-center text-sm text-gray-400">
            {t('auth.noAccount')}{' '}
            <Link to="/signup" className="text-primary-400 hover:text-primary-300">
              {t('auth.signup')}
            </Link>
          </p>
        </div>
      </div>
    </div>
  )
}
