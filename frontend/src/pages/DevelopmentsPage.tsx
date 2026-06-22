import { useTranslation } from 'react-i18next'
import { useState, useEffect } from 'react'
import { api } from '../../utils/api'
import { Technology, TechnologyStatus } from '../../types'

export default function DevelopmentsPage() {
  const { t } = useTranslation()
  const [technologies, setTechnologies] = useState<Technology[]>([])
  const [loading, setLoading] = useState(true)
  const [selectedCategory, setSelectedCategory] = useState<string>('all')
  const [searchQuery, setSearchQuery] = useState('')

  const categories = [
    'medicine', 'ai', 'education', 'chemistry', 'physics',
    'biology', 'energy', 'robotics', 'space', 'ecology'
  ]

  useEffect(() => {
    loadTechnologies()
  }, [])

  const loadTechnologies = async () => {
    try {
      const response = await api.get('/technologies')
      setTechnologies(response.data.data || response.data)
    } catch (error) {
      console.error('Failed to load technologies:', error)
    } finally {
      setLoading(false)
    }
  }

  const filteredTechnologies = technologies.filter(tech => {
    const matchesCategory = selectedCategory === 'all' || tech.category === selectedCategory
    const matchesSearch = tech.title.toLowerCase().includes(searchQuery.toLowerCase()) ||
                         tech.description.toLowerCase().includes(searchQuery.toLowerCase())
    return matchesCategory && matchesSearch
  })

  const getStatusColor = (status: TechnologyStatus) => {
    const colors = {
      draft: 'bg-gray-500',
      research: 'bg-blue-500',
      prototype: 'bg-yellow-500',
      selling: 'bg-purple-500',
      licensing: 'bg-indigo-500',
      investor_searching: 'bg-green-500',
      ready: 'bg-emerald-500',
      available: 'bg-teal-500'
    }
    return colors[status] || 'bg-gray-500'
  }

  if (loading) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-xl">{t('common.loading')}</div>
      </div>
    )
  }

  return (
    <div className="min-h-screen py-12 px-4">
      <div className="max-w-7xl mx-auto">
        <h1 className="text-4xl font-bold mb-8 gradient-text">{t('development.title')}</h1>
        
        {/* Search and Filter */}
        <div className="glass card p-6 mb-8">
          <div className="flex flex-col md:flex-row gap-4">
            <input
              type="text"
              placeholder={t('development.search')}
              value={searchQuery}
              onChange={(e) => setSearchQuery(e.target.value)}
              className="flex-1 px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:border-primary-500"
            />
            <select
              value={selectedCategory}
              onChange={(e) => setSelectedCategory(e.target.value)}
              className="px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:border-primary-500"
            >
              <option value="all">{t('development.filter')}</option>
              {categories.map(cat => (
                <option key={cat} value={cat}>{t(`categories.${cat}`)}</option>
              ))}
            </select>
          </div>
        </div>

        {/* Technologies Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {filteredTechnologies.map(tech => (
            <div key={tech.id} className="glass card overflow-hidden hover:scale-105 transition-transform">
              {tech.images?.[0] && (
                <img 
                  src={tech.images[0]} 
                  alt={tech.title}
                  className="w-full h-48 object-cover"
                />
              )}
              <div className="p-6">
                <div className="flex items-center justify-between mb-3">
                  <span className={`px-3 py-1 rounded-full text-xs font-medium text-white ${getStatusColor(tech.status)}`}>
                    {t(`development.statuses.${tech.status}`) || tech.status}
                  </span>
                  <span className="text-sm text-gray-400">TRL {tech.trl}</span>
                </div>
                <h3 className="text-xl font-bold mb-2">{tech.title}</h3>
                <p className="text-gray-400 text-sm mb-4 line-clamp-3">{tech.description}</p>
                
                {tech.cost && (
                  <div className="mb-4">
                    <p className="text-sm text-gray-400">{t('development.investment')}</p>
                    <p className="text-lg font-semibold">{tech.cost} {tech.currency}</p>
                  </div>
                )}
                
                <div className="flex items-center justify-between">
                  <span className="text-sm text-gray-400">
                    {t('development.author')}: {tech.owner?.name || 'Unknown'}
                  </span>
                  <button className="btn-primary text-sm py-2 px-4">
                    {t('development.invest')}
                  </button>
                </div>
              </div>
            </div>
          ))}
        </div>

        {filteredTechnologies.length === 0 && (
          <div className="glass card p-12 text-center">
            <p className="text-gray-400">{t('common.noResults')}</p>
          </div>
        )}
      </div>
    </div>
  )
}
