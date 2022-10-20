import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-side-menu',
  templateUrl: './side.component.html',
  styleUrls: ['./side.component.scss']
})
export class SideComponent implements OnInit {
  links = [
    {
      url: '/publications',
      name: 'Publications'
    },
  ];

  constructor(private router: Router) {}

  ngOnInit() {}

  isMenuItemIsActive(item): boolean {
    return item.url === this.router.url;
  }
}
