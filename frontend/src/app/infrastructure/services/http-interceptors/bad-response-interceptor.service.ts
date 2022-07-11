import { Injectable } from '@angular/core';
import {
  HttpErrorResponse,
  HttpEvent,
  HttpHandler,
  HttpInterceptor,
  HttpRequest,
  HttpResponse
} from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';
import {MatSnackBar} from "@angular/material/snack-bar";
import {ErrorMessageComponent} from "../notifier/templates/error/error-message.component";

@Injectable({
  providedIn: 'root'
})
export class BadResponseInterceptorService implements HttpInterceptor {
  constructor(
    private snackBar: MatSnackBar
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
            this.notify(errorMessage);
          });
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
