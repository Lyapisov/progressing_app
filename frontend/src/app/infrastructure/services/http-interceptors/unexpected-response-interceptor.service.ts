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
import {ErrorMessageComponent} from "../notifier/templates/error/error-message.component";
import {MatSnackBar} from "@angular/material/snack-bar";

@Injectable({
  providedIn: 'root'
})
export class UnexpectedResponseInterceptorService implements HttpInterceptor {
  constructor(private snackBar: MatSnackBar) {}

  intercept(
    request: HttpRequest<any>,
    next: HttpHandler
  ): Observable<HttpEvent<any>> {
    return next.handle(request).pipe(
      catchError((error: HttpErrorResponse) => {
        if ([0, 500, 501, 502, 503, 504, 505].includes(error.status)) {
          this.notify(
            'Возникла неожиданная ошибка сервера. Повторите запрос позже.'
          );
        }
        return throwError(error);
      })
    );
  }

  public notify(message: string): void {
    this.snackBar.openFromComponent(ErrorMessageComponent, {
      data: message,
      duration: 1500,
      verticalPosition: 'top',
      panelClass: 'error-message-container'
    });
  }
}
