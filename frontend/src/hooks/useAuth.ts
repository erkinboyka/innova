import { useState, useEffect } from 'react'
import { useAuthStore } from '../stores/authStore'

export function useAuth() {
  const { user, isAuthenticated, isLoading, checkAuth, logout } = useAuthStore()
  const [isChecking, setIsChecking] = useState(true)

  useEffect(() => {
    const verifyAuth = async () => {
      await checkAuth()
      setIsChecking(false)
    }
    verifyAuth()
  }, [])

  return {
    user,
    isAuthenticated,
    isLoading: isLoading || isChecking,
    logout
  }
}

export function useRole(requiredRoles?: string[]) {
  const { user, isAuthenticated } = useAuthStore()

  const hasRole = () => {
    if (!isAuthenticated || !user) return false
    if (!requiredRoles || requiredRoles.length === 0) return true
    return requiredRoles.includes(user.role)
  }

  const isAdmin = user?.role === 'admin'
  const isScientist = user?.role === 'scientist'
  const isUniversity = user?.role === 'university'
  const isNII = user?.role === 'nii'
  const isInvestor = user?.role === 'investor'

  return {
    hasRole: hasRole(),
    isAdmin,
    isScientist,
    isUniversity,
    isNII,
    isInvestor,
    role: user?.role
  }
}
