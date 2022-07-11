import { Injectable } from '@angular/core';
import { AuthToken } from './auth-token';
import { Observable } from 'rxjs';
import { TokenService } from './token.service';

@Injectable({
  providedIn: 'root'
})
export class RefreshHandlerService {
  constructor(private tokenService: TokenService) {}

  public execute(
    refreshToken: string
  ): Observable<AuthToken> {
    return this.tokenService.refresh(refreshToken);
  }
}
