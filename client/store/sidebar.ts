import { Module, Mutation, VuexModule } from 'vuex-module-decorators';

@Module({
  stateFactory: true,
})
export default class SidebarModule extends VuexModule {
  private categoryGroups: any[] = [];
  private categories: any[] = [];

  @Mutation
  public setCategoryGroups(categoryGroups: any) {
    this.categoryGroups = categoryGroups;
  }

  @Mutation
  public setCategory(categories: any) {
    this.categories.push(categories);
  }
}
