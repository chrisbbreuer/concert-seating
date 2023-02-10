export default function fetch(url: string, options?: any) {
  const config = useRuntimeConfig()

  return useFetch(url, {
    ...options,
    baseURL: config.public.API_URL,
  })
}
