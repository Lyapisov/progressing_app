import { Injectable } from '@angular/core';
import {
  HttpErrorResponse,
  HttpEvent,
  HttpHandler,
  HttpInterceptor,
  HttpRequest
} from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';
import { AuthTokenProviderService } from '../auth-token-provider.service';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class UnauthorizedResponseInterceptorService implements HttpInterceptor {
  constructor(
      private authTokenProvider: AuthTokenProviderService,
      private router: Router) {}

  intercept(
    request: HttpRequest<any>,
    next: HttpHandler
  ): Observable<HttpEvent<any>> {
    return next.handle(request).pipe(
      catchError((error: HttpErrorResponse) => {
        if (error.status == 401) {
            this.router.navigate(['login']);
        }
        return throwError(error);
      })
    );
  }
}
