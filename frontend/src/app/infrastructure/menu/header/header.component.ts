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
      url: '/profile/mine',
      nameIcon: 'account_circle'
    },
    {
      url: '/logout',
      nameIcon: 'exit_to_app'
    },
  ];

  constructor(private router: Router) {}

  ngOnInit() {}

  isMenuItemIsActive(item): boolean {
    return item.url === this.router.url;
  }
}
