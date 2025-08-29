import { axiosInstance } from '@/config'
import { useQuery } from '@tanstack/vue-query'

export const useRegisterQuery = () => {
  return useQuery({
    queryKey: ['register'],
    queryFn: async () => {
      const response = await axiosInstance.post('/auth/register')
      return response.data
    },
    retry: false,
  })
}
