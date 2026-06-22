import { BrowserRouter as Router, Routes, Route } from 'react-router-dom'
import { I18nextProvider } from 'react-i18next'
import i18n from './i18n/config'
import Layout from './components/Layout'
import HomePage from './pages/HomePage'
import LoginPage from './pages/LoginPage'
import DashboardPage from './pages/DashboardPage'
import DevelopmentsPage from './pages/DevelopmentsPage'
import MarketplacePage from './pages/MarketplacePage'
import GrantsPage from './pages/GrantsPage'
import EventsPage from './pages/EventsPage'
import ProfilePage from './pages/ProfilePage'
import NotFoundPage from './pages/NotFoundPage'

function App() {
  return (
    <I18nextProvider i18n={i18n}>
      <Router>
        <Routes>
          <Route path="/" element={<Layout />}>
            <Route index element={<HomePage />} />
            <Route path="login" element={<LoginPage />} />
            <Route path="dashboard" element={<DashboardPage />} />
            <Route path="developments" element={<DevelopmentsPage />} />
            <Route path="marketplace" element={<MarketplacePage />} />
            <Route path="grants" element={<GrantsPage />} />
            <Route path="events" element={<EventsPage />} />
            <Route path="profile/:id" element={<ProfilePage />} />
            <Route path="*" element={<NotFoundPage />} />
          </Route>
        </Routes>
      </Router>
    </I18nextProvider>
  )
}

export default App
