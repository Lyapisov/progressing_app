import { Component, OnInit } from '@angular/core';
import { AuthTokenProviderService } from '../../../services/auth-token-provider.service';
import { Router } from '@angular/router';
import {LoginFormData} from "../../components/forms/login-form/login-form-data";
import {LoginHandlerService} from "../../../../application/login/login-handler.service";
import {AuthToken} from "../../../../application/login/auth-token";

@Component({
  selector: 'app-login-page',
  templateUrl: './login-page.component.html',
  styleUrls: ['./login-page.component.css']
})
export class LoginPageComponent implements OnInit {
  constructor(
    private loginHandler: LoginHandlerService,
    private authProvider: AuthTokenProviderService,
    private router: Router
  ) {}

  ngOnInit() {}

  onLogin(data: LoginFormData) {
    this.loginHandler
      .execute(data.login, data.password)
      .subscribe((value: AuthToken) => {
        this.authProvider.setToken(value);
        this.router.navigate(['/']);
      });
  }
}
