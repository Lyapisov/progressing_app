import { Injectable } from '@angular/core';
import { AuthToken } from './auth-token';
import { Observable } from 'rxjs';
import { TokenService } from './token.service';

@Injectable({
  providedIn: 'root'
})
export class LoginHandlerService {
  constructor(private tokenService: TokenService) {}

  public execute(
    loginValue: string,
    password: string
  ): Observable<AuthToken> {
    return this.tokenService.login(loginValue, password);
  }
}
