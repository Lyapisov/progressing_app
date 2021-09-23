import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';


const routes: Routes = [
  {
    // path: '',
    // component: BaseComponent,
    // children: [
    //   {
    //     path: 'deals',
    //     component: DealsPageComponent,
    //     canActivate: [LocalStorageRouteGuardService]
    //   },
    // ],
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule],
})
export class AppRoutingModule {}
