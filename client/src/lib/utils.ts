import { EntityError } from '@/lib/http'
import { DEFAULT_IMAGE_FAILED } from '../constants/path'
// import { UseFormSetError } from 'react-hook-form'
// import { useForm, useSetFormErrors, useFormErrors } from 'vee-validate';

export const handleErrorApi = ({
  error,
  setError,
  duration,
}: {
  error: any
  setError?: (field: string, message: string) => void
  duration?: number
}) => {
  try {
    if (error instanceof EntityError) {
      error.payload.errors.forEach((item) => {
        setError(item.field, item.message)
      })
    } else {
      console.log(
        'error: ',
        error?.payload?.message ?? 'Lỗi không xác định hình',
      )
    }
  } catch (error) {
    console.log('error: ', error?.payload?.message ?? 'Lỗi không xác định hình', error)
  }
}
/**
 * Xóa đi ký tự `/` đầu tiên của path
 */
export const normalizePath = (path: string) => {
  return path.startsWith('/') ? path.slice(1) : path
}

// export const decodeJWT = <Payload = any>(token: string) => {
//     return jwt.decode(token) as Payload
// }

/**
 * format date type dd/MM/yyyy
 * @param date
 * @returns
 */
export const formatDate = (date: Date | String, formatSign = '/') => {
  let dateFormat = new Date()
  if (typeof date === 'string') {
    dateFormat = new Date(date)
  } else {
    dateFormat = date as Date
  }

  const day = dateFormat.getDate().toString().padStart(2, '0')
  const month = (dateFormat.getMonth() + 1).toString().padStart(2, '0')
  const year = dateFormat.getFullYear()
  return `${day}${formatSign}${month}${formatSign}${year}`
}

//
export const triggerFileInput = (id: string) => {
  const fileInput = document.querySelector(`input#${id}`) as HTMLInputElement
  fileInput.click()
}

export function handleImageError(event) {
  event.target.src = DEFAULT_IMAGE_FAILED
  if (this.imageLoaded) {
    this.imageLoaded = false
  } else {
    this.imageLoaded = true
  }
}

export function handleImageSuccess(event) {
  if (this.imageLoaded) {
    this.imageLoaded = true
  }
}

export const formatDateTime = (dateTimeString, showtime = false) => {
  if (!dateTimeString) {
    return ''
  }
  const date = new Date(dateTimeString)
  const day = date.getDate().toString().padStart(2, '0')
  const month = (date.getMonth() + 1).toString().padStart(2, '0')
  const year = date.getFullYear()
  const hours = date.getHours().toString().padStart(2, '0')
  const minutes = date.getMinutes().toString().padStart(2, '0')
  return `${showtime ? `${hours}:${minutes}` : ''} ${day}/${month}/${year}`
}
