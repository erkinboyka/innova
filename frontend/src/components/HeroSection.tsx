import { useRef } from 'react'
import { useTranslation } from 'react-i18next'
import { motion, useScroll, useTransform } from 'framer-motion'
import ParticlesBackground from './ParticlesBackground'

export default function HeroSection() {
  const { t } = useTranslation()
  const containerRef = useRef<HTMLDivElement>(null)
  
  const { scrollYProgress } = useScroll({
    target: containerRef,
    offset: ["start start", "end start"]
  })

  const y = useTransform(scrollYProgress, [0, 1], ["0%", "50%"])
  const opacity = useTransform(scrollYProgress, [0, 0.5], [1, 0])

  return (
    <motion.div 
      ref={containerRef}
      style={{ y, opacity }}
      className="relative h-screen flex items-center justify-center overflow-hidden"
    >
      <ParticlesBackground />
      
      <div className="relative z-10 text-center px-4">
        <motion.h1 
          initial={{ scale: 0.8, opacity: 0 }}
          animate={{ scale: 1, opacity: 1 }}
          transition={{ duration: 1, ease: "easeOut" }}
          className="text-6xl md:text-8xl font-bold mb-6"
        >
          <span className="gradient-text text-glow">{t('hero.title')}</span>
        </motion.h1>
        
        <motion.p
          initial={{ y: 20, opacity: 0 }}
          animate={{ y: 0, opacity: 1 }}
          transition={{ delay: 0.3, duration: 0.8 }}
          className="text-xl md:text-2xl text-gray-300 mb-4 max-w-3xl mx-auto"
        >
          {t('hero.subtitle')}
        </motion.p>
        
        <motion.p
          initial={{ y: 20, opacity: 0 }}
          animate={{ y: 0, opacity: 1 }}
          transition={{ delay: 0.5, duration: 0.8 }}
          className="text-lg text-primary-400 mb-8 italic"
        >
          {t('hero.slogan')}
        </motion.p>
        
        <motion.div
          initial={{ y: 20, opacity: 0 }}
          animate={{ y: 0, opacity: 1 }}
          transition={{ delay: 0.7, duration: 0.8 }}
        >
          <a href="#journey" className="btn-primary inline-block">
            {t('hero.cta')}
          </a>
        </motion.div>
      </div>

      {/* Scroll indicator */}
      <motion.div
        initial={{ opacity: 0 }}
        animate={{ opacity: 1 }}
        transition={{ delay: 1, duration: 0.5 }}
        className="absolute bottom-10 left-1/2 transform -translate-x-1/2"
      >
        <motion.div
          animate={{ y: [0, 10, 0] }}
          transition={{ repeat: Infinity, duration: 1.5 }}
          className="w-6 h-10 border-2 border-white/30 rounded-full flex justify-center pt-2"
        >
          <motion.div
            animate={{ opacity: [1, 0, 1] }}
            transition={{ repeat: Infinity, duration: 1.5 }}
            className="w-1 h-2 bg-white rounded-full"
          />
        </motion.div>
      </motion.div>
    </motion.div>
  )
}
