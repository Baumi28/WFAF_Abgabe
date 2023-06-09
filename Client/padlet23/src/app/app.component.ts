import {Component} from '@angular/core';
import {Entry, Padlet} from './shared/padlet';
import {AuthenticationService} from "./shared/authentication.service";

@Component({
  selector: 'bs-root',
  templateUrl: './app.component.html',
  styles: []
})
export class AppComponent {

  constructor(public authService: AuthenticationService) {
  }

  getLoginLabel(){
    if(this.authService.isLoggedIn()){
      return "Logout"
    } else {
      return "Login"
    }
  }
}
