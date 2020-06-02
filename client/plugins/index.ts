export default {
  delay(ms: number) {
    return new Promise((resolve) => setTimeout(resolve, ms));
  },

  isValid(pattern: string, length: string, subject: string) {
    return new RegExp(pattern.replace(/\\\\/g, '\\')).test(subject) && subject.length <= parseInt(length);
  },

  setCookie(name: string, value: string) {
    document.cookie = `${name}=${value}`;
  },

  getCookie(name: string) {
    name += '=';
    var cookies = decodeURIComponent(document.cookie).split(';');
    for (let cookie of cookies) {
      while (cookie.charAt(0) == ' ') {
        cookie = cookie.substring(1);
      }
      if (cookie.indexOf(name) == 0) {
        return cookie.substring(name.length, cookie.length);
      }
    }
    return '';
  },
};
