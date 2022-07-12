import { Injectable } from '@angular/core';
import { MatSnackBar } from '@angular/material/snack-bar';
import { ErrorMessageComponent } from './templates/error/error-message.component';
import { SuccessMessageComponent } from './templates/success/success-message.component';

@Injectable({
  providedIn: 'root'
})
export class NotifierService {
  constructor(private snackBar: MatSnackBar) {}

  public notifyAboutSuccess(message: string): void {
    this.snackBar.openFromComponent(SuccessMessageComponent, {
      data: message,
      duration: 1500,
      verticalPosition: 'top',
      panelClass: 'success-message-container'
    });
  }

  public notifyAboutError(message: string): void {
    this.snackBar.openFromComponent(ErrorMessageComponent, {
      data: message,
      duration: 1500,
      verticalPosition: 'top',
      panelClass: 'error-message-container'
    });
  }
}
