import { Module, Mutation, VuexModule } from 'vuex-module-decorators';

@Module({
  stateFactory: true,
})
export default class SidebarModule extends VuexModule {
  private categoryGroups: any[] = [];
  private categories: { [categoryGroup: string]: any[] } = {};

  @Mutation
  public setCategoryGroups(categoryGroups: any) {
    this.categoryGroups = categoryGroups;
    for (const categoryGroup of this.categoryGroups) {
      this.categories[categoryGroup.id] = [];
    }
  }

  @Mutation
  public setCategory(payload: { categoryGroup: any; category: any }) {
    this.categories[payload.categoryGroup.id] = payload.category;
  }
}
