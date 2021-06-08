export default {
  set: function(key, value) {
    window.localStorage[key] = value
  },
  get: function(key) {
    if(!this.has(key)) return ""
    return window.localStorage[key]
  },
  has: function(key) {
    return window.localStorage.hasOwnProperty(key)
  },
  delete: function(key) {
    if(this.has(key)) delete window.localStorage[key]
  }
}