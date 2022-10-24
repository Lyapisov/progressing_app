import {Component, OnInit} from "@angular/core";
import {
  GetPublicationsListHandlerService
} from "../../../../../application/publications/handlers/get-publications-list-handler.service";
import {Publication} from "../../../../../application/publications/models/publication";
import {MatDialog, MatDialogConfig} from "@angular/material/dialog";
import {
  CreatePublicationDialogComponent
} from "../../../components/dialogs/publication/create/create-publication-dialog.component";
import {
  LikePublicationHandlerService
} from "../../../../../application/publications/handlers/like-publication--handler.service";
import {
  PublishPublicationHandlerService
} from "../../../../../application/publications/handlers/publish-publication--handler.service";

@Component({
  selector: 'app-publications-page',
  templateUrl: './publications-list-page.component.html',
  styleUrls: ['./publications-list-page.component.scss']
})
export class PublicationsListPageComponent implements OnInit {
  constructor(
    private getListHandler: GetPublicationsListHandlerService,
    private likeHandler: LikePublicationHandlerService,
    private publishHandler: PublishPublicationHandlerService,
    private dialog: MatDialog
  ) {
  }

  list: Publication[] = [];
  isLoading = false;

  ngOnInit() {
    this.loadPublicationsList();

    this.dialog.afterAllClosed.subscribe(
      () => this.loadPublicationsList()
    );
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
    dialogConfig.minWidth = '70%';
    dialogConfig.minHeight = '70%';

    this.dialog.open(CreatePublicationDialogComponent, dialogConfig);
  }

  public like(publicationId: string): void {
    this.likeHandler.execute(publicationId).subscribe(
      () => this.loadPublicationsList()
    );
  }

  public publish(publicationId: string): void {
    this.publishHandler.execute(publicationId).subscribe(
      () => this.loadPublicationsList()
    );
  }
}
