import { Module, Mutation, VuexModule } from 'vuex-module-decorators';

@Module({
  stateFactory: true,
})
export default class DashboardManageModule extends VuexModule {
  private items!: any[];

  public get getItems() {
    for (const item of this.items) {
      if (item.status == 0) {
        item._rowVariant = 'secondary';
      } else if (item.status == 2) {
        item._rowVariant = 'warning';
      } else {
        delete item._rowVariant;
      }
    }

    return this.items;
  }

  @Mutation
  public setItems(items: any[]) {
    this.items = items;
  }

  @Mutation
  public editItem(payload: { index: number; item: any }) {
    Object.assign(this.items[payload.index], payload.item);
  }

  @Mutation
  public addItem(item: any) {
    this.items.push(item);
  }

  @Mutation
  public removeItem(index: number) {
    this.items.splice(index, 1);
  }
}
