import { axiosInstance } from '@/config'
import type { RegisterType } from '@/types/schema/auth-schema'
import { useMutation } from '@tanstack/vue-query'
import type { AxiosError, AxiosResponse } from 'axios'
import { useToast } from 'primevue'

type Props<T> = {
  onSuccess?: (data: unknown) => void
  onError?: (err: T) => void
  onSettled?: () => void
  onMutate?: () => void
}

export const useRegisterMutation = <T>(props?: Props<T> | undefined) => {
  const toast = useToast()

  return useMutation({
    mutationKey: ['register'],
    mutationFn: async (data: RegisterType) =>
      await axiosInstance({
        url: '/auth/register',
        method: 'POST',
        data,
      }),
    retry: false,

    // response events
    onSuccess: (data: AxiosResponse) => {
      toast.add({
        severity: 'success',
        summary: 'Success',
        detail: data?.data?.message,
        life: 3000,
      })

      if (props?.onSuccess) props?.onSuccess(data)
    },

    onError: (err: AxiosError) => {
      if (props?.onError) props?.onError(err?.response?.data as T)
    },

    onSettled: () => {
      if (props?.onSettled) props?.onSettled()
    },

    onMutate: () => {
      if (props?.onMutate) props?.onMutate()
    },
  })
}
