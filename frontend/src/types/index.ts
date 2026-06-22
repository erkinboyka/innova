export interface User {
  id: number
  name: string
  email: string
  role: UserRole
  avatar?: string
  phone?: string
  organization_name?: string
  position?: string
  bio?: string
  expertise?: string[]
  created_at: string
  updated_at: string
}

export type UserRole = 'user' | 'scientist' | 'university' | 'nii' | 'investor' | 'admin'

export interface Technology {
  id: number
  title: string
  description: string
  problem?: string
  solution?: string
  technology_details?: string
  trl: number
  status: TechnologyStatus
  category: string
  owner_id: number
  organization_id?: number
  authors?: string[]
  images?: string[]
  files?: string[]
  video_url?: string
  model_3d_url?: string
  cost?: number
  currency: string
  investment_goal?: number
  roi?: number
  created_at: string
  updated_at: string
  owner?: User
}

export type TechnologyStatus = 
  | 'draft'
  | 'research'
  | 'prototype'
  | 'selling'
  | 'licensing'
  | 'investor_searching'
  | 'ready'
  | 'available'

export interface Grant {
  id: number
  title: string
  description: string
  organizer: string
  amount: number
  currency: string
  deadline: string
  requirements: string[]
  documents?: string[]
  status: GrantStatus
  created_at: string
  updated_at: string
}

export type GrantStatus = 'active' | 'closed' | 'upcoming'

export interface News {
  id: number
  title: string
  content: string
  image?: string
  category: NewsCategory
  published_at: string
  created_at: string
}

export type NewsCategory = 'conference' | 'exhibition' | 'forum' | 'competition' | 'hackathon' | 'news'

export interface Event {
  id: number
  title: string
  description: string
  date: string
  location: string
  image?: string
  type: EventType
  registration_url?: string
}

export type EventType = 'conference' | 'exhibition' | 'forum' | 'competition' | 'hackathon'

export interface Patent {
  id: number
  title: string
  number: string
  description: string
  technology_id: number
  status: string
  filed_date: string
  granted_date?: string
}

export interface Investment {
  id: number
  investor_id: number
  technology_id: number
  amount: number
  currency: string
  status: InvestmentStatus
  created_at: string
}

export type InvestmentStatus = 'pending' | 'active' | 'completed' | 'cancelled'

export interface Organization {
  id: number
  name: string
  type: OrganizationType
  description?: string
  logo?: string
  website?: string
  address?: string
  contact_email?: string
  contact_phone?: string
}

export type OrganizationType = 'university' | 'nii' | 'company' | 'government'

export interface ApiResponse<T> {
  data: T
  message?: string
  success: boolean
}

export interface PaginatedResponse<T> {
  data: T[]
  current_page: number
  last_page: number
  per_page: number
  total: number
}
