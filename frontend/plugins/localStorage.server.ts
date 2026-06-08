export default defineNuxtPlugin(() => {
  if (process.server) {
    // Polyfill localStorage for server-side rendering
    globalThis.localStorage = {
      getItem: () => null,
      setItem: () => {},
      removeItem: () => {},
      clear: () => {},
      key: () => null,
      length: 0
    };
  }
});