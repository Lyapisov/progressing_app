import {Injectable} from "@angular/core";

@Injectable({
  providedIn: 'root'
})
export class DateFormatter {
  public createDateStringFromTimestamp(timestamp: number): string
  {
    const date = new Date(timestamp * 1000);

    return date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate();
  }
}
