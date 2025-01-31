import api from "@/services/api.ts";

class AuthService {
  // ========================
  // user handling methods
  // ========================
  authenticated(): boolean  {
    try {
      this.getToken()

      return true
    } catch (error) {
      console.log(error)

      return false
    }
  }

  getToken(): string {
    const token = localStorage.getItem('token')

    if (null === token) {
      throw Error('token is null')
    }

    return token
  }

  async login(username: string, password: string) {
    return this.post('auth', {
      email: username, password: password
    }).then((response) => {
      localStorage.setItem('token', response.data.token)

      return response.data.token
    })
  }

  logout() {
    localStorage.removeItem('token')
  }

  // ================
  // basic methods
  // ================
  async get(url: string) {
    let headers = {}

    if (this.authenticated()) {
      headers = {Authorization: `Bearer ${this.getToken()}`}
    }

    return api.get(url, {headers: headers})
  }

  async post(url: string, data: object) {
    let headers = {}

    if (this.authenticated()) {
      headers = {Authorization: `Bearer ${this.getToken()}`}
    }

    return api.post(url, data, {headers: headers})
  }
}

export default new AuthService()
