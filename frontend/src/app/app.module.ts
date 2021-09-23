import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { MatFormFieldModule } from '@angular/material/form-field';
import { ReactiveFormsModule } from '@angular/forms';
import { MatButtonModule } from '@angular/material/button';
import { HTTP_INTERCEPTORS, HttpClientModule } from '@angular/common/http';
import { MatSnackBarModule } from '@angular/material/snack-bar';
import { config } from '../app.config';
import {AppComponent} from "./infrastructure/presentation/app.component";
import {AppRoutingModule} from "./infrastructure/presentation/app-routing.module";

@NgModule({
  declarations: [
    AppComponent
  ],
  imports: [
    BrowserModule,
    BrowserAnimationsModule,
    MatFormFieldModule,
    ReactiveFormsModule,
    MatButtonModule,
    HttpClientModule,
    MatSnackBarModule,
    AppRoutingModule,
  ],
  entryComponents: [],
  providers: [
    { provide: 'apiUrl', useValue: config.apiUrl },
  ],
  bootstrap: [AppComponent]
})
export class AppModule {}
