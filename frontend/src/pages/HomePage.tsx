import { HeroSection, JourneySection } from '../components'

export default function HomePage() {
  return (
    <div className="min-h-screen">
      <HeroSection />
      <JourneySection />
      
      {/* Categories Preview */}
      <section className="py-20 px-4">
        <div className="max-w-7xl mx-auto">
          <h2 className="text-3xl md:text-4xl font-bold text-center mb-12 gradient-text">
            Категории инноваций
          </h2>
          
          <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            {[
              { icon: '🏥', name: 'Медицина' },
              { icon: '🤖', name: 'ИИ' },
              { icon: '🎓', name: 'Образование' },
              { icon: '⚗️', name: 'Химия' },
              { icon: '⚛️', name: 'Физика' },
              { icon: '🧬', name: 'Биология' },
              { icon: '⚡', name: 'Энергетика' },
              { icon: '🦾', name: 'Робототехника' },
              { icon: '🛰️', name: 'Космос' },
              { icon: '🌱', name: 'Экология' },
            ].map((category, index) => (
              <div
                key={index}
                className="glass card p-6 text-center hover:scale-105 transition-transform cursor-pointer"
              >
                <div className="text-4xl mb-3">{category.icon}</div>
                <h3 className="font-semibold">{category.name}</h3>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-20 px-4">
        <div className="max-w-4xl mx-auto text-center glass rounded-3xl p-12">
          <h2 className="text-3xl md:text-4xl font-bold mb-6">
            Готовы начать инновационное путешествие?
          </h2>
          <p className="text-gray-300 mb-8 text-lg">
            Присоединяйтесь к платформе INNOVA.TJ и станьте частью научной экосистемы Таджикистана
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/login" className="btn-primary">
              Зарегистрироваться
            </a>
            <a href="/marketplace" className="btn-secondary">
              Изучить разработки
            </a>
          </div>
        </div>
      </section>
    </div>
  )
}
