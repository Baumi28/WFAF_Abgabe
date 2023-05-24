import {Injectable} from '@angular/core';
import {HttpClient} from "@angular/common/http";
import jwt_decode from "jwt-decode";

interface Token {
  exp: number,
  user: {
    id: string;
  }
}

@Injectable({
  providedIn: 'root'
})
export class AuthenticationService {
  private api = 'http://padlet23.s2010456002.student.kwmhgb.at/api/auth';

  constructor(private http: HttpClient) {
  }

  login(email: String, password: String) {
    return this.http.post(`${this.api}/login`, {email: email, password: password});
  }

  setSessionStorage(token: string) {
    sessionStorage.setItem("token", token);
    const decodedToken = jwt_decode(token) as Token;
    console.log(decodedToken);
    sessionStorage.setItem("userId", decodedToken.user.id);
  }


  logout() {
    this.http.post(`${this.api}/logout`, {});
    sessionStorage.removeItem("token");
    sessionStorage.removeItem("userId");
  }

  isLoggedIn() {
    if (sessionStorage.getItem("token")) {
      let token: string = <string>sessionStorage.getItem("token");
      const decodedToken = jwt_decode(token) as Token;
      let expirationDate: Date = new Date(0);
      expirationDate.setUTCSeconds(decodedToken.exp);
      if (expirationDate < new Date()) {
        console.log("token expired");
        sessionStorage.removeItem("token");
        return false;
      }
      return true;
    } else {
      return false;
    }
  }

  isLoggedOut() {
    return !this.isLoggedIn();
  }
}
