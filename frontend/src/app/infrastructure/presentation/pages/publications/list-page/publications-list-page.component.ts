import {Component, OnInit} from "@angular/core";
import {
  GetPublicationsListHandlerService
} from "../../../../../application/publications/handlers/get-publications-list-handler.service";
import {Publication} from "../../../../../application/publications/models/publication";
import {MatDialog, MatDialogConfig} from "@angular/material/dialog";
import {
  CreatePublicationDialogComponent
} from "../../../components/dialogs/publication/create/create-publication-dialog.component";

@Component({
  selector: 'app-publications-page',
  templateUrl: './publications-list-page.component.html',
  styleUrls: ['./publications-list-page.component.scss']
})
export class PublicationsListPageComponent implements OnInit {
  constructor(
    private getListHandler: GetPublicationsListHandlerService,
    private dialog: MatDialog
  ) {
  }

  list: Publication[] = [];
  isLoading = false;

  ngOnInit() {
    this.loadPublicationsList();
  }

  private loadPublicationsList(): void {
    this.isLoading = true;
    this.getListHandler.execute().subscribe(
      (items: Publication[]) => {
        this.list = items;
        this.isLoading = false;
      }
    )
  }

  public openCreatingDialog(): void {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    this.dialog.open(CreatePublicationDialogComponent, dialogConfig);
  }
}
