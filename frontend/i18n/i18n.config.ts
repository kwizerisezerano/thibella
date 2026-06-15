import en from '../lang/en.json';
import rw from '../lang/rw.json';
import fr from '../lang/fr.json';
import sw from '../lang/sw.json';

export default defineI18nConfig(() => ({
  legacy: false,
  locale: 'rw',
  fallbackLocale: 'rw',
  messages: {
    en,
    rw,
    fr,
    sw
  }
}))
