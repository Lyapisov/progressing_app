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
import {HeaderComponent} from "./infrastructure/menu/header/header.component";
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
import {UserService} from "./application/users/user.service";
import {TokenService} from "./application/login/token.service";
import {LogoutPageComponent} from "./infrastructure/presentation/pages/logout-page/logout-page.component";
import {MatIconModule} from "@angular/material/icon";
import {MatSelectModule} from "@angular/material/select";
import {HomePageComponent} from "./infrastructure/presentation/pages/game/home-page/home-page.component";
import {ProloguePageComponent} from "./infrastructure/presentation/pages/game/prologue-page/prologue-page.component";
import {ChooseProfilePageComponent} from "./infrastructure/presentation/pages/registration/choose-profile-page/choose-profile-page.component";
import {CreateFanPageComponent} from "./infrastructure/presentation/pages/registration/create-fan-page/create-fan-page.component";
import {CreateProfileFormComponent} from "./infrastructure/presentation/components/forms/profile/create-profile-form/create-profile-form.component";
import {ProfilesService} from "./application/profiles/profiles.service";
import {EditProfileFormComponent} from "./infrastructure/presentation/components/forms/profile/edit-profile-form/edit-profile-form.component";
import {FormBuilderService} from "./infrastructure/services/form/form-builder.service";
import {BaseFormComponent} from "./infrastructure/presentation/components/forms/base/base-form/base-form.component";
import {CreateMusicianPageComponent} from "./infrastructure/presentation/pages/registration/create-musician-page/create-musician-page.component";
import {CreateProducerPageComponent} from "./infrastructure/presentation/pages/registration/create-producer-page/create-producer-page.component";
import {LayoutModule} from "@angular/cdk/layout";
import {SideComponent} from "./infrastructure/menu/side/side.component";
import {
  PublicationsListPageComponent
} from "./infrastructure/presentation/pages/publications/list-page/publications-list-page.component";
import {MatCardModule} from "@angular/material/card";
import {PublicationsService} from "./application/publications/publications.service";
import {MatDialogModule} from "@angular/material/dialog";
import {
  CreatePublicationDialogComponent
} from "./infrastructure/presentation/components/dialogs/publication/create/create-publication-dialog.component";
import {
  CreatePublicationFormComponent
} from "./infrastructure/presentation/components/forms/publications/create/create-publication-form.component";

@NgModule({
  declarations: [
    AppComponent,
    BaseComponent,
    HeaderComponent,
    SideComponent,
    LoginPageComponent,
    LoginFormComponent,
    ErrorMessageComponent,
    SuccessMessageComponent,
    ProfilePageComponent,
    RegistrationUserPageComponent,
    RegistrationFormComponent,
    LogoutPageComponent,
    HomePageComponent,
    ProloguePageComponent,
    ChooseProfilePageComponent,
    CreateFanPageComponent,
    CreateProfileFormComponent,
    EditProfileFormComponent,
    BaseFormComponent,
    CreateMusicianPageComponent,
    CreateProducerPageComponent,
    PublicationsListPageComponent,
    CreatePublicationDialogComponent,
    CreatePublicationFormComponent,
  ],
  imports: [
    BrowserModule,
    LayoutModule,
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
    MatCardModule,
    MatDialogModule,
  ],
  entryComponents: [
    CreatePublicationDialogComponent,
  ],
  providers: [
    { provide: 'apiUrl', useValue: config.apiUrl },
    { provide: AuthTokenProviderService, useClass: AuthTokenInMemoryProviderService},
    { provide: RegistrationService},
    { provide: UserService},
    { provide: TokenService},
    { provide: ProfilesService},
    { provide: FormBuilderService},
    { provide: PublicationsService},
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
