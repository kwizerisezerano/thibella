export async function apiFetch<T>(
  endpoint: string,
  options: RequestInit = {}
): Promise<T> {
  const baseUrl = useRuntimeConfig().public.baseUrl;

  const cleanEndpoint = endpoint.startsWith('/') ? endpoint.substring(1) : endpoint;

  const token = import.meta.client ? localStorage.getItem('token') : null;

  try {
    const url = `${baseUrl}/${cleanEndpoint}`;
    console.log('Fetching from 1:', url);
    const response = await fetch(url, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        ...(token ? { Authorization: `Bearer ${token}` } : {}),
        ...options.headers,
      },
      ...options,
    });
    
    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }

    return await response.json();
  } catch (error) {
    console.error('API Fetch Error:', error);
    throw error;
  }
}
