import { useTranslation } from 'react-i18next'
import { motion } from 'framer-motion'
import { useRef } from 'react'
import { useScroll, useTransform } from 'framer-motion'

export default function JourneySection() {
  const { t } = useTranslation()
  const containerRef = useRef<HTMLDivElement>(null)

  const journeyStages = [
    { year: t('journey.year1991'), icon: '🏗️', description: '1991' },
    { year: t('journey.revival'), icon: '🌱', description: 'Возрождение' },
    { year: t('journey.development'), icon: '📈', description: 'Развитие' },
    { year: t('journey.education'), icon: '🎓', description: 'Образование' },
    { year: t('journey.science'), icon: '🔬', description: 'Наука' },
    { year: t('journey.innovations'), icon: '💡', description: 'Инновации' },
    { year: t('journey.digitalization'), icon: '💻', description: 'Цифровизация' },
    { year: t('journey.year2026'), icon: '🚀', description: '2026' },
    { year: t('journey.future'), icon: '✨', description: 'Будущее' },
  ]

  return (
    <section id="journey" ref={containerRef} className="py-20 px-4">
      <div className="max-w-7xl mx-auto">
        <motion.h2
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-4xl md:text-5xl font-bold text-center mb-16 gradient-text"
        >
          {t('journey.title')}
        </motion.h2>

        <div className="relative">
          {/* Timeline line */}
          <div className="absolute left-1/2 transform -translate-x-1/2 h-full w-1 bg-gradient-to-b from-primary-500 via-accent-500 to-primary-500 rounded-full hidden md:block" />

          <div className="space-y-12 md:space-y-24">
            {journeyStages.map((stage, index) => (
              <motion.div
                key={index}
                initial={{ opacity: 0, x: index % 2 === 0 ? -50 : 50 }}
                whileInView={{ opacity: 1, x: 0 }}
                viewport={{ once: true, margin: "-100px" }}
                transition={{ duration: 0.6, delay: index * 0.1 }}
                className={`flex items-center ${
                  index % 2 === 0 ? 'md:flex-row' : 'md:flex-row-reverse'
                } flex-col md:flex-row`}
              >
                <div className="flex-1 w-full md:w-auto">
                  <motion.div
                    whileHover={{ scale: 1.05 }}
                    className="glass card p-6 md:p-8 ml-8 md:ml-0"
                  >
                    <div className="text-4xl mb-4">{stage.icon}</div>
                    <h3 className="text-xl font-bold mb-2">{stage.year}</h3>
                    <p className="text-gray-400">{stage.description}</p>
                  </motion.div>
                </div>

                {/* Timeline dot */}
                <div className="hidden md:flex absolute left-1/2 transform -translate-x-1/2 w-8 h-8 bg-primary-500 rounded-full border-4 border-gray-900 items-center justify-center z-10">
                  <div className="w-3 h-3 bg-white rounded-full animate-pulse" />
                </div>

                <div className="flex-1 w-full md:w-auto" />
              </motion.div>
            ))}
          </div>
        </div>

        {/* Final message */}
        <motion.div
          initial={{ opacity: 0, scale: 0.8 }}
          whileInView={{ opacity: 1, scale: 1 }}
          viewport={{ once: true }}
          className="text-center mt-20 p-8 glass rounded-2xl"
        >
          <h3 className="text-3xl font-bold mb-4 gradient-text">INNOVA.TJ</h3>
          <p className="text-xl text-gray-300">
            Platform of Innovation and Commercialisation of Science Developments
          </p>
          <p className="text-primary-400 mt-4 italic">
            Innovate Today, Transform Tomorrow
          </p>
        </motion.div>
      </div>
    </section>
  )
}
