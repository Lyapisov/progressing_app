import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { MatFormFieldModule } from '@angular/material/form-field';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
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
import {ProfilePageComponent} from "./infrastructure/presentation/pages/profile-page/profile-page.component";
import {LocalStorageRouteGuardService} from "./infrastructure/services/route-guards/local-storage-route-guard.service";
import {RegistrationUserPageComponent} from "./infrastructure/presentation/pages/registration/registration-user-page/registration-user-page.component";
import {RegistrationFormComponent} from "./infrastructure/presentation/components/forms/registration-form/registration-form.component";
import {RegistrationService} from "./application/registration/registration.service";
import {ProfileService} from "./application/profile/profile.service";
import {TokenService} from "./application/login/token.service";
import {LogoutPageComponent} from "./infrastructure/presentation/pages/logout-page/logout-page.component";
import {MatIconModule} from "@angular/material/icon";
import {MatSelectModule} from "@angular/material/select";

@NgModule({
  declarations: [
    AppComponent,
    BaseComponent,
    HeaderComponent,
    LoginPageComponent,
    LoginFormComponent,
    ErrorMessageComponent,
    SuccessMessageComponent,
    ProfilePageComponent,
    RegistrationUserPageComponent,
    RegistrationFormComponent,
    LogoutPageComponent,
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
    MatIconModule,
    MatSelectModule,
    FormsModule,
  ],
  entryComponents: [],
  providers: [
    { provide: 'apiUrl', useValue: config.apiUrl },
    { provide: AuthTokenProviderService, useClass: AuthTokenInMemoryProviderService},
    { provide: RegistrationService},
    { provide: ProfileService},
    { provide: TokenService},
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
    LocalStorageRouteGuardService
  ],
  bootstrap: [AppComponent]
})
export class AppModule {}
