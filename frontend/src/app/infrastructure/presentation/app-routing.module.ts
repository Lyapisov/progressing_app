import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import {BaseComponent} from "../base/base.component";
import {LoginPageComponent} from "./pages/login-page/login-page.component";
import {ProfilePageComponent} from "./pages/profile-page/profile-page.component";
import {LocalStorageRouteGuardService} from "../services/route-guards/local-storage-route-guard.service";
import {RegistrationUserPageComponent} from "./pages/registration/registration-user-page/registration-user-page.component";
import {LogoutPageComponent} from "./pages/logout-page/logout-page.component";
import {ChooseProfilePageComponent} from "./pages/registration/choose-profile-page/choose-profile-page.component";
import {CreateFanPageComponent} from "./pages/registration/create-fan-page/create-fan-page.component";
import {CreateMusicianPageComponent} from "./pages/registration/create-musician-page/create-musician-page.component";
import {CreateProducerPageComponent} from "./pages/registration/create-producer-page/create-producer-page.component";

const routes: Routes = [
  {
    path: '',
    redirectTo: 'profile/mine',
    pathMatch: 'full'
  },
  {
    path: '',
    component: BaseComponent,
    children: [
      {
        path: 'login',
        component: LoginPageComponent
      },
      {
        path: 'sign-up',
        component: RegistrationUserPageComponent
      },
      {
        path: 'logout',
        component: LogoutPageComponent,
        canActivate: [LocalStorageRouteGuardService]
      },
      {
        path: 'profile/mine',
        component: ProfilePageComponent,
        canActivate: [LocalStorageRouteGuardService]
      },
      {
        path: 'profile/choose',
        component: ChooseProfilePageComponent,
        canActivate: [LocalStorageRouteGuardService]
      },
      {
        path: 'profile/fan',
        component: CreateFanPageComponent,
        canActivate: [LocalStorageRouteGuardService]
      },
      {
        path: 'profile/musician',
        component: CreateMusicianPageComponent,
        canActivate: [LocalStorageRouteGuardService]
      },
      {
        path: 'profile/producer',
        component: CreateProducerPageComponent,
        canActivate: [LocalStorageRouteGuardService]
      },
    ],
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes, { relativeLinkResolution: 'legacy' })],
  exports: [RouterModule],
})
export class AppRoutingModule {}
