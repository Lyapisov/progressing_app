import { Injectable } from '@angular/core';
import {
  HttpErrorResponse,
  HttpEvent,
  HttpHandler,
  HttpInterceptor,
  HttpRequest,
} from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';
import {NotifierService} from "../notifier/notifier.service";

@Injectable({
  providedIn: 'root'
})
export class BadResponseInterceptorService implements HttpInterceptor {
  constructor(
    private notifier: NotifierService,
  ) {}

  intercept(
    request: HttpRequest<any>,
    next: HttpHandler
  ): Observable<HttpEvent<any>> {
    return next.handle(request).pipe(
      catchError((error: HttpErrorResponse) => {
        if (error.status == 400) {
          const errorMessages = error.error.error.messages;
          errorMessages.map((errorMessage: string) => {
            this.notifier.notifyAboutError(errorMessage);
          });
        }
        return throwError(error);
      })
    );
  }
}
