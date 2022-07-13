import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})
export class HeaderComponent implements OnInit {
  links = [
    {
      url: '/home',
      name: 'Home'
    },
    {
      url: '/profile/mine',
      name: 'Profile'
    },
    {
      url: '/logout',
      name: 'Logout'
    },
  ];

  constructor(private router: Router) {}

  ngOnInit() {}

  isMenuItemIsActive(item): boolean {
    return item.url === this.router.url;
  }
}
