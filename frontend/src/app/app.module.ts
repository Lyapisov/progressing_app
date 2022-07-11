import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { MatFormFieldModule } from '@angular/material/form-field';
import { ReactiveFormsModule } from '@angular/forms';
import { MatButtonModule } from '@angular/material/button';
import {HTTP_INTERCEPTORS, HttpClientModule} from '@angular/common/http';
import { MatSnackBarModule } from '@angular/material/snack-bar';
import { config } from '../app.config';
import {AppComponent} from "./infrastructure/presentation/app.component";
import {AppRoutingModule} from "./infrastructure/presentation/app-routing.module";
import {BaseComponent} from "./infrastructure/base/base.component";
import {HeaderComponent} from "./infrastructure/header/header.component";
import {LoginPageComponent} from "./infrastructure/presentation/pages/login-page/login-page.component";
import {LoginFormComponent} from "./infrastructure/presentation/components/forms/login-form/login-form.component";
import {TokenInterceptorService} from "./infrastructure/services/http-interceptors/token-interceptor.service";
import {AuthTokenProviderService} from "./infrastructure/services/auth-token-provider.service";
import {AuthTokenInMemoryProviderService} from "./infrastructure/services/auth-token-in-memory-provider.service";
import {ErrorMessageComponent} from "./infrastructure/services/notifier/templates/error/error-message.component";
import {SuccessMessageComponent} from "./infrastructure/services/notifier/templates/success/success-message.component";
import {BadResponseInterceptorService} from "./infrastructure/services/http-interceptors/bad-response-interceptor.service";
import {ForbiddenResponseInterceptorService} from "./infrastructure/services/http-interceptors/forbidden-response-interceptor.service";
import {NotFoundResponseInterceptorService} from "./infrastructure/services/http-interceptors/not-found-response-interceptor.service";
import {UnauthorizedResponseInterceptorService} from "./infrastructure/services/http-interceptors/unauthorized-response-interceptor.service";
import {UnexpectedResponseInterceptorService} from "./infrastructure/services/http-interceptors/unexpected-response-interceptor.service";
import {MatInputModule} from "@angular/material/input";

@NgModule({
  declarations: [
    AppComponent,
    BaseComponent,
    HeaderComponent,
    LoginPageComponent,
    LoginFormComponent,
    ErrorMessageComponent,
    SuccessMessageComponent,
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
    MatInputModule,
  ],
  entryComponents: [],
  providers: [
    { provide: 'apiUrl', useValue: config.apiUrl },
    { provide: AuthTokenProviderService, useClass: AuthTokenInMemoryProviderService},
    {
      provide: HTTP_INTERCEPTORS,
      useClass: TokenInterceptorService,
      multi: true
    },
    {
      provide: HTTP_INTERCEPTORS,
      useClass: BadResponseInterceptorService,
      multi: true
    },
    {
      provide: HTTP_INTERCEPTORS,
      useClass: ForbiddenResponseInterceptorService,
      multi: true
    },
    {
      provide: HTTP_INTERCEPTORS,
      useClass: NotFoundResponseInterceptorService,
      multi: true
    },
    {
      provide: HTTP_INTERCEPTORS,
      useClass: UnauthorizedResponseInterceptorService,
      multi: true
    },
    {
      provide: HTTP_INTERCEPTORS,
      useClass: UnexpectedResponseInterceptorService,
      multi: true
    },
  ],
  bootstrap: [AppComponent]
})
export class AppModule {}
