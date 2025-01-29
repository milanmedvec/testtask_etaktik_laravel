import {
    Admin,
    Resource,
    SimpleForm,
    TextInput,
    Empty,
    List,
    Datagrid,
    TextField,
    Edit,
    Create,
    ReferenceField,
    ReferenceInput,
    ReferenceArrayInput,
    Show,
    SimpleShowLayout,
    ReferenceArrayField,
} from "react-admin";
import { Layout } from "./Layout";
import { dataProvider } from "./dataProvider";

export const App = () => (
    <Admin layout={Layout} dataProvider={dataProvider}>
        <Resource
            name="authors"
            list={
                <List empty={<Empty hasCreate={true} />} filters={[
                    <TextInput source="first_name" label="First Name" alwaysOn />,
                    <TextInput source="last_name" label="Last Name" alwaysOn />,
                ]}>
                    <Datagrid>
                        <TextField source="id" />
                        <TextField source="first_name" />
                        <TextField source="last_name" />
                    </Datagrid>
                </List>
            }
            edit={
                <Edit>
                    <SimpleForm>
                        <TextInput source="first_name" />
                        <TextInput source="last_name" />
                    </SimpleForm>
                </Edit>
            }
            show={
                <Show>
                    <SimpleShowLayout>
                        <TextField source="id" />
                        <TextField source="first_name" />
                        <TextField source="last_name" />
                    </SimpleShowLayout>
                </Show>
            }
            create={
                <Create>
                    <SimpleForm>
                        <TextInput source="first_name" />
                        <TextInput source="last_name" />
                    </SimpleForm>
                </Create>
            }
        />

        <Resource
            name="tags"
            list={
                <List empty={<Empty hasCreate={true} />} filters={[
                    <TextInput source="name" label="Name" alwaysOn />,
                ]}>
                    <Datagrid>
                        <TextField source="id" />
                        <TextField source="name" />
                    </Datagrid>
                </List>
            }
            edit={
                <Edit>
                    <SimpleForm>
                        <TextInput source="name" />
                    </SimpleForm>
                </Edit>
            }
            show={
                <Show>
                    <SimpleShowLayout>
                        <TextField source="id" />
                        <TextField source="name" />
                    </SimpleShowLayout>
                </Show>
            }
            create={
                <Create>
                    <SimpleForm>
                        <TextInput source="name" />
                    </SimpleForm>
                </Create>
            }
        />

        <Resource
            name="images"
            list={
                <List empty={<Empty hasCreate={true} />} filters={[
                    <TextInput source="title" label="Title" alwaysOn />,
                ]}>
                    <Datagrid>
                        <TextField source="id" />
                        <ReferenceField resource="authors" reference="authors" source="author_id" />
                        <TextField source="title" />
                        <TextField source="url" />
                    </Datagrid>
                </List>
            }
            edit={
                <Edit>
                    <SimpleForm>
                        <ReferenceInput resource="authors" reference="authors" source="author_id" />
                        <TextInput source="title" />
                        <TextInput source="url" />
                        <ReferenceArrayInput resource="tags" reference="tags" source="tags_ids" />
                    </SimpleForm>
                </Edit>
            }
            show={
                <Show>
                    <SimpleShowLayout>
                        <ReferenceField resource="authors" reference="authors" source="author_id" />
                        <TextField source="title" />
                        <TextField source="body" />
                        <ReferenceArrayField resource="tags" reference="tags" source="tags_ids" />
                    </SimpleShowLayout>
                </Show>
            }
            create={
                <Create>
                    <SimpleForm>
                        <ReferenceInput resource="authors" reference="authors" source="author_id" />
                        <TextInput source="title" />
                        <TextInput source="url" />
                        <ReferenceArrayInput resource="tags" reference="tags" source="tags_ids" />
                    </SimpleForm>
                </Create>
            }
        />

        <Resource
            name="posts"
            list={
                <List empty={<Empty hasCreate={true} />} filters={[
                    <TextInput source="title" label="Title" alwaysOn />,
                ]}>
                    <Datagrid>
                        <TextField source="id" />
                        <ReferenceField resource="authors" reference="authors" source="author_id" />
                        <TextField source="title" />
                        <TextField source="body" />
                    </Datagrid>
                </List>
            }
            edit={
                <Edit>
                    <SimpleForm>
                        <ReferenceInput resource="authors" reference="authors" source="author_id" />
                        <TextInput source="title" />
                        <TextInput source="body" />
                        <ReferenceArrayInput resource="tags" reference="tags" source="tags_ids" />
                    </SimpleForm>
                </Edit>
            }
            show={
                <Show>
                    <SimpleShowLayout>
                        <ReferenceField resource="authors" reference="authors" source="author_id" />
                        <TextField source="title" />
                        <TextField source="body" />
                        <ReferenceArrayField resource="tags" reference="tags" source="tags_ids" />
                    </SimpleShowLayout>
                </Show>
            }
            create={
                <Create>
                    <SimpleForm>
                        <ReferenceInput resource="authors" reference="authors" source="author_id" />
                        <TextInput source="title" />
                        <TextInput source="body" />
                        <ReferenceArrayInput resource="tags" reference="tags" source="tags_ids" />
                    </SimpleForm>
                </Create>
            }
        />

        <Resource
            name="comments"
            list={
                <List empty={<Empty />}>
                    <Datagrid>
                        <TextField source="id" />
                        <TextField source="body" />
                    </Datagrid>
                </List>
            }
            edit={
                <Edit>
                    <SimpleForm>
                        <TextInput source="body" />
                    </SimpleForm>
                </Edit>
            }
            show={
                <Show>
                    <SimpleShowLayout>
                        <TextField source="id" />
                        <TextField source="body" />
                    </SimpleShowLayout>
                </Show>
            }
        />
    </Admin>
);
