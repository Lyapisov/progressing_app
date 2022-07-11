import { Injectable } from '@angular/core';
import {
  HttpEvent,
  HttpHandler,
  HttpInterceptor,
  HttpRequest
} from '@angular/common/http';
import { Observable } from 'rxjs';
import { AuthTokenProviderService } from '../auth-token-provider.service';

@Injectable({
  providedIn: 'root'
})
export class TokenInterceptorService implements HttpInterceptor {
  constructor(
    private authTokenProvider: AuthTokenProviderService
  ) {}

  intercept(
    request: HttpRequest<any>,
    next: HttpHandler
  ): Observable<HttpEvent<any>> {
    const accessToken = this.authTokenProvider.getToken();
    if (accessToken) {
      request = request.clone({
        setHeaders: {
          AUTHORIZATION: accessToken
        }
      });
    }
    return next.handle(request);
  }
}
