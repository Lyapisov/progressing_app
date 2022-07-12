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
import {NotifierService} from "../notifier/notifier.service";

@Injectable({
  providedIn: 'root'
})
export class UnexpectedResponseInterceptorService implements HttpInterceptor {
  constructor(private notifier: NotifierService,) {}

  intercept(
    request: HttpRequest<any>,
    next: HttpHandler
  ): Observable<HttpEvent<any>> {
    return next.handle(request).pipe(
      catchError((error: HttpErrorResponse) => {
        if ([0, 500, 501, 502, 503, 504, 505].includes(error.status)) {
          this.notifier.notifyAboutError(
            'Возникла неожиданная ошибка сервера. Повторите запрос позже.'
          );
        }
        return throwError(error);
      })
    );
  }
}
