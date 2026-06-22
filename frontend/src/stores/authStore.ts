import { create } from 'zustand'
import axios from 'axios'

interface User {
  id: number
  name: string
  email: string
  role: string
  avatar?: string
  phone?: string
}

interface AuthState {
  user: User | null
  token: string | null
  isAuthenticated: boolean
  isLoading: boolean
  login: (email: string, password: string) => Promise<void>
  loginWithPhone: (phone: string, code: string) => Promise<void>
  loginWithGoogle: () => void
  register: (data: RegisterData) => Promise<void>
  logout: () => void
  checkAuth: () => Promise<void>
}

interface RegisterData {
  name: string
  email: string
  phone?: string
  password: string
  password_confirmation: string
}

const API_URL = import.meta.env.VITE_API_URL || 'http://localhost:8000/api/v1'

export const useAuthStore = create<AuthState>((set, get) => ({
  user: null,
  token: localStorage.getItem('token'),
  isAuthenticated: !!localStorage.getItem('token'),
  isLoading: false,

  checkAuth: async () => {
    const token = get().token
    if (!token) {
      set({ isAuthenticated: false, user: null })
      return
    }

    try {
      const response = await axios.get(`${API_URL}/user`, {
        headers: { Authorization: `Bearer ${token}` }
      })
      set({ user: response.data, isAuthenticated: true })
    } catch (error) {
      set({ token: null, isAuthenticated: false, user: null })
      localStorage.removeItem('token')
    }
  },

  login: async (email: string, password: string) => {
    set({ isLoading: true })
    try {
      const response = await axios.post(`${API_URL}/login`, {
        email,
        password
      })
      const { access_token, user } = response.data
      localStorage.setItem('token', access_token)
      set({ token: access_token, user, isAuthenticated: true, isLoading: false })
    } catch (error) {
      set({ isLoading: false })
      throw error
    }
  },

  loginWithPhone: async (phone: string, code: string) => {
    set({ isLoading: true })
    try {
      // TODO: Implement phone login with SMS code
      const response = await axios.post(`${API_URL}/login`, {
        phone,
        password: code // Using code as password for now
      })
      const { access_token, user } = response.data
      localStorage.setItem('token', access_token)
      set({ token: access_token, user, isAuthenticated: true, isLoading: false })
    } catch (error) {
      set({ isLoading: false })
      throw error
    }
  },

  loginWithGoogle: async () => {
    // TODO: Implement Google OAuth
    window.location.href = `${API_URL}/auth/google`
  },

  register: async (data: RegisterData) => {
    set({ isLoading: true })
    try {
      const response = await axios.post(`${API_URL}/register`, data)
      const { access_token, user } = response.data
      localStorage.setItem('token', access_token)
      set({ token: access_token, user, isAuthenticated: true, isLoading: false })
    } catch (error) {
      set({ isLoading: false })
      throw error
    }
  },

  logout: () => {
    localStorage.removeItem('token')
    set({ token: null, user: null, isAuthenticated: false })
  }
}))
